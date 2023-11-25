<?php

namespace App\Repositorys;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Package;

class PackageRepository
{
    public function getAllPackages(): Collection
    {
        return Package::all();
    }

    public function store(array $data): Package {
        return Package::create($data);
    }
}
