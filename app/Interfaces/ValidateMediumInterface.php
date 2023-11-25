<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ValidateMediumInterface
{
    public function validate(array $row, string $readedFile_id) : null|Model;
}
