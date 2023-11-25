<?php

namespace App\Repositorys;

use App\Models\FileExport;

class FileExportRepository
{
    public function create(array $data)
    {
        return FileExport::create($data);
    }
}
