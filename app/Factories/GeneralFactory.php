<?php

namespace App\Factories;

use App\Interfaces\LoadingInterfaces;
use App\Interfaces\ValidateMediumInterface;

class GeneralFactory implements LoadingInterfaces
{
    public function proccessMedium(array $row, ValidateMediumInterface $validateMedium, string $readed_file_id): void
    {
        $validateMedium->validate($row, $readed_file_id);
    }
}
