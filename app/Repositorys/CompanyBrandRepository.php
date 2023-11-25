<?php

namespace App\Repositorys;

use App\Models\CompanyBrand;
use App\Models\Medium;
use App\Models\PackageCompany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CompanyBrandRepository
{

    public function getAllContractedBrands() {
        $auth_company_id = Auth::user()->company_id;
        return PackageCompany::where('company_id', $auth_company_id)
            ->with('package.companyBrandLocations')
            ->get();
    }

    public function getPackagesCompanyByMedium(string $medium_id)
    {
        $auth_company_id = Auth::user()->company_id;
        return PackageCompany::where('company_id', $auth_company_id)
            ->with('package.companiesBrands', function ($query) use ($medium_id) {
                $query->where('medium_id', $medium_id)
                ->with('brand');
            })
            ->get();
    }

    public function getContractedBrandsOOH(array $brand_id, Medium $medium) : Collection {
        return CompanyBrand::whereIn('brand_id', $brand_id)
            ->where('medium_id', $medium->id)
            ->with('companyBrandLocations.state')
            ->get();
    }

    public function getContractedBrandsForOrigins(array $brand_id, Medium $medium)
    {
        return CompanyBrand::whereIn('brand_id', $brand_id)
            ->where('medium_id', $medium->id)
            ->with('companyBrandLocations.origin')
            ->get();
    }

    public function store(array $data) : CompanyBrand
    {
        return CompanyBrand::create($data);
    }
}
