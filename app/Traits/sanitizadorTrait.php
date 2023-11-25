<?php

namespace App\Traits;

use App\Exceptions\HeaderFileException;
use App\Exceptions\IncorrectFileException;

trait sanitizadorTrait {


    public function trim($row): string
    {
        return trim(preg_replace("/[\r\n|\n|\r]+/", "", $row));
    }


    public function validateHeadingRow($row, $valueRow): void
    {
        if ($this->trim($row) != $valueRow) {
            $exceptionMessage = "Formato de cabecera inválido en: " . $valueRow. ". Verifica el formato de este archivo";
            throw new HeaderFileException($exceptionMessage);
        }
    }

    public function validateMedium($value, $medium): bool
    {
        return $value == $medium;
        /*if ($value !== $medium) {
            $exceptionMessage = "Formato inválido en el medio. Verifica el formato de este archivo";
            throw new IncorrectFileException($exceptionMessage);
        }*/
    }
}
