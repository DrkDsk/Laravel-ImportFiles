<?php

namespace App\Repositorys;

use App\Models\Medium;
use Illuminate\Database\Eloquent\Collection;

class MediumRepository
{
    public function getAll() : Collection
    {
        return Medium::all();
    }

    public function getByOwnName(string $name) : Medium {
        return Medium::where('name', $name)->first();
    }
}
