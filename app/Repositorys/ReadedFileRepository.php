<?php

namespace App\Repositorys;

use App\Models\ReadedFile;

class ReadedFileRepository
{
    public function getReadedFileByOrigin(string $fileName, $origin)
    {
        return ReadedFile::where('fileName', $fileName)->where('origin', $origin)->first();
    }

    public function getReadedFile(string $fileName)
    {
        return ReadedFile::where('fileName', $fileName)->first();
    }

    public function createReadFile(array $data)
    {
        return ReadedFile::create($data);
    }
}
