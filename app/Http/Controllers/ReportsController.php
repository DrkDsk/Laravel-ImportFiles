<?php

namespace App\Http\Controllers;

use App\Enums\TypeOfMedium;
use App\Models\FileExport;
use App\Http\Requests\FilterRegistersRequest;
use App\Http\Resources\GeneralResource;
use App\Jobs\ExportReportJob;
use App\Models\Medium;
use App\Repositorys\CompanyBrandRepository;
use App\Repositorys\FileExportRepository;
use App\Repositorys\GeneralRepository;
use App\Services\CompanyBrandsService;
use App\Services\FileSystemService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportsController extends Controller
{

    public function __construct(
        protected GeneralRepository $generalRepository,
        protected CompanyBrandRepository $companyBrandRepository,
        protected CompanyBrandsService $companyBrandsService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $brandsContracted = $this->companyBrandRepository->getAllContractedBrands();
        $mediumsFilteredCount = $this->companyBrandsService->getCountOfMediumsContracted($brandsContracted);

        return Inertia::render("Dashboard/Reports/Index", [
            "mediumsFilteredCount" => $mediumsFilteredCount
        ]);
    }

    public function show(Medium $medium, FilterRegistersRequest $request): GeneralResource
    {
        $registers = [];
        if ($medium->name == strtoupper(TypeOfMedium::Revista->value) || $medium->name == strtoupper(TypeOfMedium::Prensa->value)) {
            $registers = $this->generalRepository->getRegistersForRevista(
                $medium->id,
                $request->validated('brands_id'),
                $request->validated('origins_id'),
                $request->validated('date_start'),
                $request->validated('date_end')
            );
        }

        if ($medium->name == strtoupper(TypeOfMedium::OOH->value)) {
            $registers = $this->generalRepository->getRegistersForOOH(
                $medium->id,
                $request->validated('brands_id'),
                $request->validated('states_id'),
                $request->validated('date_start'),
                $request->validated('date_end')
            );
        }

        if ($medium->name == strtoupper(TypeOfMedium::Television->value)) {
            $registers = $this->generalRepository->getRegistersForTV(
                $medium->id,
                $request->validated('brands_id'),
                $request->validated('origins_id'),
                $request->validated('date_start'),
                $request->validated('date_end')
            );
        }

        return (new GeneralResource($registers));
    }

    public function export(Medium $medium, FilterRegistersRequest $request, FileExportRepository $fileExportRepository): JsonResponse
    {
        $newFileToExportId = $fileExportRepository->create([
            'medium_id' => $medium->id,
            'data'      => $request->all()
        ])->id;

        ExportReportJob::dispatch($medium, $request->all(), $newFileToExportId);
        return response()->json([
            'status' => 200,
            'data'   => [
                'request' => $request->all(),
                'file_id' => $newFileToExportId
            ]
        ]);
    }

    public function download(FileExport $fileExport, FileSystemService $fileSystemService): BinaryFileResponse|JsonResponse
    {
        $file = $fileSystemService->downloadReport($fileExport);

        if (!$file) {
            return response()->json([
                "downloaded" => false,
                "status" => 200,
                "fileExport" => $fileExport
            ]);
        }

        return $file;
    }
}
