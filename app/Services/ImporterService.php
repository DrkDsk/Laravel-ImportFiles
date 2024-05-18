<?php

namespace App\Services;

use App\Enums\TypeOfMedium;
use App\Imports\OOHImport;
use App\Imports\PrensaImport;
use Maatwebsite\Excel\Facades\Excel;

class ImporterService {

    public function storeFile(string $origin): void
    {
        $filename              = request()->file('file')->getClientOriginalName();
        request()->file('file')->storeAs('files/' . $origin, $filename, ['disk' => 'public']);
    }

    public function getImport(string $origin, string $fileName)
    {
        $importOptionsOfOrigin = [
            strtolower(TypeOfMedium::OOH->value) => new OOHImport($fileName),
            strtolower(TypeOfMedium::Prensa->value) => new PrensaImport($fileName)
        ];

        return $importOptionsOfOrigin[strtolower($origin)] ?? null;
    }

    public function import(object $import, string $fileStoragePath): void
    {
        Excel::import($import, $fileStoragePath);
    }
}
