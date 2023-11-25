<?php

namespace App\Listeners;

use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class AfterImportListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $readedFile = $event->readedFile;
        $readedFile->update([
            'finish' => now()->format('Y-m-d H:i:s'),
            'count'  => $readedFile->countRegisters
        ]);

        $emailService = new EmailService($event->fileName, $event->origin);
        $emailService->validateIfHasException($readedFile->exception);
    }
}
