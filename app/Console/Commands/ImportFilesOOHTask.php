<?php

namespace App\Console\Commands;

use App\Services\ReaderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportFilesOOHTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-files-ooh-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected const ORIGIN = "ooh";
    protected const MAIN_PATH = "files/" . ImportFilesOOHTask::ORIGIN . "/";

    /**
     * Execute the console command.
     */
    public function handle(ReaderService $readerService) : void
    {
        $allFiles = Storage::disk('public')->files(ImportFilesOOHTask::MAIN_PATH);
        foreach ($allFiles as $file) {
            $readerService->import( ImportFilesOOHTask::ORIGIN, ImportFilesOOHTask::MAIN_PATH, $file);
        }
    }
}
