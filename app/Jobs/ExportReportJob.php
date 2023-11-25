<?php

namespace App\Jobs;

use App\Exports\ExportRegisters;
use App\Models\FileExport;
use App\Http\Requests\FilterRegistersRequest;
use App\Models\Medium;
use App\Repositorys\GeneralRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private FilterRegistersRequest $request;
    private Medium $medium;
    private GeneralRepository $generalRepository;
    private string $idExportFile;
    public function __construct(Medium $medium, $request, string $idExportFile)
    {
        $this->medium            = $medium;
        $this->request           = new FilterRegistersRequest($request);
        $this->generalRepository = new GeneralRepository();
        $this->idExportFile      = $idExportFile;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $registers = [];
        if ($this->medium->name == "REVISTA" || $this->medium->name == "PRENSA") {
            $registers = $this->generalRepository->getRegistersForRevista(
                $this->medium->id,
                $this->request->get('brands_id'),
                $this->request->get('origins_id'),
                $this->request->get('date_start'),
                $this->request->get('date_end')
            );
        }

        if ($this->medium->name == "OOH") {
            $registers = $this->generalRepository->getRegistersForOOH(
                $this->medium->id,
                $this->request->get('brands_id'),
                $this->request->get('states_id'),
                $this->request->get('date_start'),
                $this->request->get('date_end')
            );
        }

        $today = date('d-m-Y-H-i-s');
        $file_path_name = 'files/exports/REPORTE_' . $this->medium->name . '_'  . $today . '.xlsx';
        $storage_path_spreadsheet = public_path('storage/'.$file_path_name);

        Excel::store(new ExportRegisters($registers), $file_path_name, 'public');
        $fileExportUpdate = FileExport::where('id', $this->idExportFile)->first();
        $fileExportUpdate->update(['filePath' => $storage_path_spreadsheet]);
    }
}
