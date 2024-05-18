<?php

namespace App\Services;

use App\Exceptions\HeaderFileException;
use App\Exceptions\IncorrectFileException;
use App\Models\ReadedFile;
use App\Repositorys\ReadedFileRepository;
use Maatwebsite\Excel\Validators\ValidationException;

class ReaderService
{

    public function __construct(
        protected ReadedFileRepository $readedFileRepository,
        protected ImporterService $importerService)
    {

    }

    public function import(string $origin, string $mainPath, $file): void
    {
        $fileName = str_replace($mainPath,"", $file);
        $fileInDatabase = $this->readedFileRepository->getReadedFileByOrigin($fileName, $origin);

        //if not exists the file in database, create a new register and process it
        if (!$fileInDatabase) {

            $newReadFileData = [
                'fileName' => $fileName,
                'origin' => $origin,
                'start' => date('Y-m-d')
            ];

            $readFile = $this->readedFileRepository->createReadFile($newReadFileData);

            try {
                $typeImport = $this->importerService->getImport($origin, $fileName);
                $this->importerService->import($typeImport, $this->getFileStoragePath($file));

            } catch (IncorrectFileException | HeaderFileException | ValidationException $exception) {
                $this->setExceptionToFile($readFile, $exception->getMessage());
            }
        }
    }

    private function setExceptionToFile(ReadedFile $readFile, string $exceptionGetMessage): void
    {
        $readFile->update([
            'exception' => $exceptionGetMessage
        ]);
    }

    private function getFileStoragePath($file): string
    {
        return public_path("storage/" . $file);
    }
}
