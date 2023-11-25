<?php

namespace App\Factories;

use App\Models\Package;
use App\Repositorys\PackageRepository;
use Illuminate\Database\Eloquent\Collection;

class PackageFactory
{
    public function __construct(protected PackageRepository $packageRepository)
    {
    }

    public function getAllPackages(): Collection
    {
        return $this->packageRepository->getAllPackages();
    }

    public function store(array $data) : Package {
        return $this->packageRepository->store($data);
    }

}
