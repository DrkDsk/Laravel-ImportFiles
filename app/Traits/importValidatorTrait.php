<?php

namespace App\Traits;

use App\Exceptions\DuplicatedRowException;

trait importValidatorTrait {

    private array $uniqueRecords = [];

    /**
     * @throws DuplicatedRowException
     */
    public function validateIfRowIsDuplicated(string $uniqueKey, int $rowNumber): void
    {
        if (isset($this->uniqueRecords[$uniqueKey])) {
            throw new DuplicatedRowException('Se ha encontrado un valor duplicado en la fila: ' . $rowNumber-1);
        }
    }

    public function insertRowNotDuplicated(string $uniqueKey): void
    {
        $this->uniqueRecords[$uniqueKey] = true;
    }
}
