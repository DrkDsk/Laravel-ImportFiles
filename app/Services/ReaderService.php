<?php

namespace App\Services;

use App\Exceptions\HeaderFileException;
use App\Exceptions\IncorrectFileException;
use App\Repositorys\ReadedFileRepository;
use Maatwebsite\Excel\Validators\ValidationException;

class ReaderService
{
    private ImporterService $importerService;
    private ReadedFileRepository $readedFileRepository;
    private string $fileStoragePath,$origin,$typeOfMedium,$file_name;

    public function __construct(string $typeOfMedium, string $fileName, $file)
    {
        $this->typeOfMedium = $typeOfMedium;
        $this->origin       = strtolower($this->typeOfMedium);
        $this->fileStoragePath = $file;
        $this->file_name = $fileName;

        $this->importerService = new ImporterService($this->typeOfMedium);
        $this->readedFileRepository = new ReadedFileRepository();
        $this->import();
    }

    private function import(): void
    {
        try {
            $import = $this->importerService->getImport($this->origin, $this->file_name);
            $this->importerService->import($import, $this->getFileStoragePath());

        } catch (IncorrectFileException | HeaderFileException | ValidationException $exception) {
            $this->setExceptionToFile($exception->getMessage());
        }
    }

    private function setExceptionToFile(string $exceptionGetMessage): void
    {
        $readedFile = $this->readedFileRepository->getReadedFile($this->file_name);
        if ($readedFile) {
            $readedFile->update(['exception' => $exceptionGetMessage]);
        }
    }

    private function getFileStoragePath(): string
    {
        return public_path("storage/" . $this->fileStoragePath);
    }
}
