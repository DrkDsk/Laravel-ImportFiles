<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class OriginService
{
    public function getOriginsByMediums(Collection $mediums): array
    {
        $origins = [];

        foreach ($mediums as $medium) {
            $origins[$medium->name] = $medium->origins ?? [];
        }

        return $origins;
    }
}
