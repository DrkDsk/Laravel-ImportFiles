<?php

namespace App\Interfaces;

interface LoadingInterfaces
{
    public function proccessMedium(array $row, ValidateMediumInterface $validateMedium, string $readed_file_id);
}
