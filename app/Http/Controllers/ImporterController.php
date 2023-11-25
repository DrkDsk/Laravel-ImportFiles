<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImporterRequest;
use App\Http\Resources\GeneralResource;
use App\Models\ReadedFile;
use App\Services\ImporterService;

class ImporterController extends Controller
{
    public function store(ImporterRequest $request): GeneralResource
    {
        $origin   = $request->validated('origin');
        $file = ReadedFile::where('fileName', $request->file('file')->getClientOriginalName())->where('origin', $origin)->first();
        if ($file) {
            return (new GeneralResource([
                'message' => 'Archivo importado anteriormente'
            ]));
        }

        $importerService = new ImporterService($origin);
        $importerService->storeFile();

        return (new GeneralResource([
            'message' => 'Archivo importado'
        ]));
    }
}
