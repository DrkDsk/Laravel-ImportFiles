<?php

namespace App\Console\Commands;

use App\Repositorys\ReadedFileRepository;
use App\Services\ReaderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportFilesRevistaTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-files-revista-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected const ORIGIN = "revista";
    protected const MAIN_PATH = "files/" . SELF::ORIGIN . "/";

    /**
     * Execute the console command.
     */
    public function handle(ReadedFileRepository $readedFileRepository) : void
    {
        $allFiles = Storage::disk('public')->files(self::MAIN_PATH);
        foreach ($allFiles as $file) {
            $fileName = str_replace(self::MAIN_PATH,"",$file);
            $fileInDatabase = $readedFileRepository->getReadedFileByOrigin($fileName, SELF::ORIGIN);
            is_null($fileInDatabase) && new ReaderService(ucfirst(SELF::ORIGIN), $fileName, $file);
        }
    }
}
