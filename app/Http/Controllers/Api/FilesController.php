<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;
use App\Models\ReadedFile;
use App\Models\Register;
use App\Services\FileSystemService;

class FilesController extends Controller
{

    public function __construct(private readonly FileSystemService $fileSystemService)
    {

    }

    public function index()
    {
        $files = ReadedFile::orderBy('created_at', 'DESC')->get();
        return (new GeneralResource($files));
    }

    public function show(ReadedFile $readedFile): GeneralResource
    {
        return (new GeneralResource([
            'readedFile' => $readedFile,
            'registers'  => $readedFile->registers
        ]));
    }

    public function destroy($readedFileId): GeneralResource
    {
        $readedFile = ReadedFile::where('id', $readedFileId)->first();

        if ($readedFile) {
            $this->fileSystemService->delete('files/'. $readedFile->origin . '/' . $readedFile->fileName);
            $readedFile->delete();
            $readedFile->registers()->delete();
        }

        $countDeleted = Register::where('readed_file_id', $readedFileId)->delete();

        return (new GeneralResource([
            'message' => 'Archivo eliminado con '.$countDeleted. ' registros'
        ]));
    }
}
