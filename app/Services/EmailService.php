<?php

namespace App\Services;

use App\Mail\NotificationTaskEmail;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    private array $emailAddress;
    private string $file_name, $origin;
    public function __construct(string $file_name, string $origin)
    {
        $this->file_name = $file_name;
        $this->origin    = $origin;

        if (env('APP_ENV') == "local") {
            $this->emailAddress = explode(',', config('mail.receiverLocal'));
        } else {
            $this->emailAddress = explode(',', config('mail.receiverProd'));
        }
    }

    public function validateIfHasException($exception): void
    {
        if (!$exception) {
            $this->success();
        } else {
            $this->fail($exception);
        }
    }

    public function success()
    {
        try {
            $mailData = [
                "title"    => "Archivo importado correctamente",
                "body"     => "Nombre del archivo: " . $this->file_name . "\n\n" . "Origen: " . strtoupper($this->origin)
            ];
            return Mail::to($this->emailAddress)->send(new NotificationTaskEmail($mailData));
        } catch (\Exception) {}
    }

    public function fail(string $exceptionMessage)
    {
        try {
            $mailData = [
                "title"    => "Ha ocurrido un error al importar el archivo. Error: " . $exceptionMessage,
                "body"     => "Nombre del archivo: " . $this->file_name . "\n\n" . "Origen: " . strtoupper($this->origin)
            ];

            return Mail::to($this->emailAddress)->send(new NotificationTaskEmail($mailData));
        } catch (\Exception) {}
    }
}
