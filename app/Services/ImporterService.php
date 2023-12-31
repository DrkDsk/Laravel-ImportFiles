<?php

namespace App\Services;

use App\Enums\TypeOfMedium;
use App\Imports\OOHImport;
use App\Imports\PrensaImport;
use Maatwebsite\Excel\Facades\Excel;

class ImporterService {

    private string $typeOfMedium;

    public function __construct(string $typeOfMedium) {
        $this->typeOfMedium = strtolower($typeOfMedium);
    }

    public function storeFile(): void
    {
        $filename              = request()->file('file')->getClientOriginalName();
        request()->file('file')->storeAs('files/' . $this->typeOfMedium, $filename, ['disk' => 'public']);
    }

    public function getImport(string $origin, string $fileName)
    {
        $importOptionsOfOrigin = [
            strtolower(TypeOfMedium::OOH->value) => new OOHImport($fileName, $origin),
            strtolower(TypeOfMedium::Prensa->value) => new PrensaImport($fileName, $origin)
        ];

        return $importOptionsOfOrigin[$this->typeOfMedium];
    }

    public function import(object $import, string $fileStoragePath): void
    {
        Excel::import($import, $fileStoragePath);
    }

}
