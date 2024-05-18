<?php

namespace App\Console\Commands;

use App\Services\ReaderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportFilesPrensaTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-files-prensa-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected const ORIGIN = "prensa";
    protected const MAIN_PATH = "files/" . ImportFilesPrensaTask::ORIGIN . "/";

    /**
     * Execute the console command.
     */
    public function handle(ReaderService $readerService): void
    {
        $allFiles = Storage::disk('public')->files(ImportFilesPrensaTask::MAIN_PATH);
        foreach ($allFiles as $file) {
            $readerService->import( ImportFilesPrensaTask::ORIGIN, ImportFilesPrensaTask::MAIN_PATH, $file);
        }
    }
}
