<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ImporterRequest;
use App\Http\Resources\GeneralResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\ReadedFile;
use App\Services\ImporterService;
use Illuminate\Support\Facades\Session;
use App\Services\FileSystemService;
use App\Models\Register;

class FileController extends Controller
{
    public function __construct(private readonly FileSystemService $fileSystemService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {

        $message = Session::get('message');
        $status = Session::get('status');

        return Inertia::render('Dashboard/Files/Index', [
            "files" => ReadedFile::orderBy('created_at', 'DESC')->get(),
            "message" => $message,
            "status" => $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render('Dashboard/Files/Create', [
            'message' => '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImporterRequest $request) : Response
    {
        $origin = $request->validated('origin');
        $file = ReadedFile::where('fileName', $request->file('file')->getClientOriginalName())->where('origin', $origin)->first();
        if ($file) {
            return Inertia::render('Dashboard/Files/Create', [
                'message' => 'Archivo importado anteriormente',
                'status' => 400
            ]);
        }

        $importerService = new ImporterService($origin);
        $importerService->storeFile();

        return Inertia::render('Dashboard/Files/Create', [
            'message' => 'Archivo importado',
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($readedFileId): RedirectResponse
    {
        $readedFile = ReadedFile::where('id', $readedFileId)->first();

        if ($readedFile) {
            $this->fileSystemService->delete('files/' . $readedFile->origin . '/' . $readedFile->fileName);
            $readedFile->delete();
            $readedFile->registers()->delete();
        }

        $countDeleted = Register::where('readed_file_id', $readedFileId)->delete();

        return redirect()->route('dashboard.files.index')->with(['status' => 200, 'message' => 'Archivo eliminado con éxito!']);
    }
}
