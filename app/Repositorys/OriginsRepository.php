<?php

namespace App\Repositorys;

use App\Models\Origin;

class OriginsRepository
{
    public function getOriginsByGroupId(string $group_id)
    {
        return Origin::where('group_id', $group_id)->with('medium','group')->get();
    }

    public function findOriginsByIds(array $brands_id)
    {
        return Origin::whereIn('id', $brands_id)->get();
    }
}
