<?php

namespace App\Repositorys;

use App\Models\Brand;
use Illuminate\Support\Collection;

class BrandRepository
{
    public function getAll() : Collection
    {
        return Brand::orderBy('name', 'ASC')->pluck('id', 'name');
    }

    public function findByIds($brands)
    {
        return Brand::whereIn('id', $brands)->get();
    }

}
