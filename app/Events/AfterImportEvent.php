<?php

namespace App\Events;

use App\Models\ReadedFile;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterImportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ReadedFile $readedFile;
    public string $fileName, $origin;
    /**
     * Create a new event instance.
     */
    public function __construct(ReadedFile $readedFile, string $fileName, string $origin)
    {
        $this->readedFile = $readedFile;
        $this->fileName   = $fileName;
        $this->origin     = $origin;
    }
}
