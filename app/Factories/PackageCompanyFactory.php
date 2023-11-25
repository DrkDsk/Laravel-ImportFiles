<?php

namespace App\Factories;


use App\Repositorys\PackageCompanyRepository;
use App\Models\PackageCompany;

class PackageCompanyFactory
{

    public function __construct(protected PackageCompanyRepository $packageCompanyRepository)
    {
    }

    public function store(string $package_id, string $company_id): PackageCompany
    {
        $data = [
            'package_id' => $package_id,
            'company_id' => $company_id
        ];

        return $this->packageCompanyRepository->store($data);
    }
}
