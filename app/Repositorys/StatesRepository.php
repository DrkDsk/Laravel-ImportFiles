<?php

namespace App\Repositorys;

use App\Models\State;
use Illuminate\Support\Collection;

class StatesRepository
{
    public function getAll() : Collection
    {
        return State::whereNotNull('name')->get();
    }

    public function findStatesByIds(array $data)
    {
        return State::whereIn('id', $data)->get();
    }
}
