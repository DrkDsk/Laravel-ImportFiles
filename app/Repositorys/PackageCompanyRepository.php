<?php

namespace App\Repositorys;

use App\Models\PackageCompany;

class PackageCompanyRepository
{
    public function store(array $data) : PackageCompany
    {
        return PackageCompany::create($data);
    }
}
