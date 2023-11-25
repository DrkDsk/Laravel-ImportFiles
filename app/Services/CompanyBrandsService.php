<?php

namespace App\Services;

use App\Enums\TypeOfMedium;
use App\Interfaces\HireServiceInterface;
use App\Models\CompanyBrand;
use App\Repositorys\CompanyBrandRepository;
use App\Repositorys\MediumRepository;
use Illuminate\Database\Eloquent\Collection;

class CompanyBrandsService implements HireServiceInterface
{

    public function __construct(
        protected CompanyBrandRepository $companyBrandRepository,
        protected MediumRepository $mediumRepository)
    {
    }

    public function getCountOfMediumsContracted(Collection $mediumsFiltered): array
    {
        $listOfMediums = [];
        $mediumsFilteredCount = [];

        foreach (TypeOfMedium::cases() as $medium) {
            $mediumName = strtoupper($medium->value);
            $listOfMediums[$mediumName] = [];
            $mediumsFilteredCount[$mediumName] = 0;
        }

        foreach ($mediumsFiltered as $mediumFiltered) {
            foreach ($mediumFiltered->package->companyBrandLocations as $companyBrandLocation) {
                if ($companyBrandLocation->origin && isset($listOfMediums[$companyBrandLocation->origin->medium->name])) {
                    $mediumName = $companyBrandLocation->origin->medium->name;
                } elseif ($companyBrandLocation->state && isset($listOfMediums[strtoupper(TypeOfMedium::OOH->value)])) {
                    $mediumName = strtoupper(TypeOfMedium::OOH->value);
                } else {
                    continue;
                }

                $originId = $companyBrandLocation->origin ? $companyBrandLocation->origin->id : $companyBrandLocation->state->id;

                if (!in_array($originId, $listOfMediums[$mediumName])) {
                    $listOfMediums[$mediumName][] = $originId;
                    $mediumsFilteredCount[$mediumName]++;
                }
            }
        }

        return $mediumsFilteredCount;
    }

    public function getStatesFromCompanyBrands(Collection $companyBrands): array
    {
        $states = [];

        foreach ($companyBrands as $companyBrand) {
            foreach ($companyBrand->companyBrandLocations as $companyBrandLocation) {
                $states[] = $companyBrandLocation->state;
            }
        }

        return $states;
    }

    public function getOriginsFromCompanyBrands(Collection $companyBrands): array
    {
        $origins = [];

        foreach ($companyBrands as $companyBrand) {
            foreach ($companyBrand->companyBrandLocations as $companyBrandLocation) {
                $origins[] = $companyBrandLocation->origin;
            }
        }

        return $origins;
    }

    public function filterCompanyBrandsFromPackagesCompanies(Collection $packagesCompanies): array
    {
        $brands = [];
        $allIds = [];

        foreach ($packagesCompanies as $package) {
            foreach ($package->package->companiesBrands as $brand) {
                if (!in_array($brand->brand->id, $allIds)) {
                    $brands[] = $brand->brand;
                    $allIds[] = $brand->brand->id;
                }
            }
        }
        return $brands;
    }

    public function storeCompanyBrand(string $package_id, string $brand_id, string $medium_name): bool|CompanyBrand
    {
        $medium = $this->mediumRepository->getByOwnName($medium_name);

        if (!$medium) {
            return false;
        }

        $data = [
            'package_id' => $package_id,
            'brand_id'   => $brand_id,
            'medium_id'  => $medium->id
        ];

        return $this->companyBrandRepository->store($data);
    }

    public function hireServiceOOH(string $package_id, $brand_id, array $states): bool
    {
        $medium_name = TypeOfMedium::OOH->value;
        $companyBrand = $this->storeCompanyBrand($package_id, $brand_id, $medium_name);

        if (!$companyBrand) {
            return false;
        }

        foreach ($states as $state) {
            $companyBrand->companyBrandLocations()->create([
                'state_id' => $state
            ]);
        }

        return true;
    }

    public function hireServiceOrigins(string $package_id, string $brand_id, array $origins, string $medium_name): bool
    {
        $companyBrand = $this->storeCompanyBrand($package_id, $brand_id, $medium_name);

        if (!$companyBrand) {
            return false;
        }

        foreach ($origins as $origin) {
            $companyBrand->companyBrandLocations()->create([
                'origin_id' => $origin
            ]);
        }

        return true;
    }
}
