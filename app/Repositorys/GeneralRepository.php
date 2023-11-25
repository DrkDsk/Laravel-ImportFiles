<?php

namespace App\Repositorys;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CompanyBrand;
use App\Models\Country;
use App\Models\Insertion;
use App\Models\Medium;
use App\Models\Origin;
use App\Models\Product;
use App\Models\Register;
use App\Models\State;
use App\Models\Supplier;

class GeneralRepository
{
    public function __construct(){}

    public function createMediumIfNotExists(string $name)
    {
        return Medium::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }

    public function createCountryIfNotExists(string $name)
    {
        return Country::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }

    public function getStateByAlias(string $name, string $country_id)
    {
        $state = State::where('country_id', $country_id)
            ->whereJsonContains('aliases', ['name' => strtoupper($name)])->first();

        if ($state && !$state->name) {
            $firstAlias = $state->aliases[0]["name"];
            $state->update(['name' => strtoupper($firstAlias)]);
        }

        return $state;
    }

    public function createInsertionIfNotExists(string $name, string $medium_id)
    {
        return Insertion::firstOrCreate(
            ['name' => $name, 'medium_id' => $medium_id],
            ['name' => $name, 'medium_id' => $medium_id]
        );
    }

    public function createSupplierIfNotExists($name, string $medium_id)
    {
        if ($name) {
            return Supplier::firstOrCreate(
                ['name' => $name, 'medium_id' => $medium_id],
                ['name' => $name, 'medium_id' => $medium_id]
            );
        }
    }

    public function createBrandIfNotExists($name)
    {
        if ($name) {
            return Brand::firstOrCreate(
                ['name' => $name],
                ['name' => $name, 'title' => $name]
            );
        }
    }

    public function createProductIfNotExists($name, string $medium_id)
    {
        if ($name) {
            return Product::firstOrCreate(
                ['name' => $name, 'medium_id' => $medium_id],
                ['name' => $name, 'medium_id' => $medium_id]
            );
        }
    }

    public function createCategoryIfNotExists($name)
    {
        if ($name) {
            return Category::firstOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
    }

    public function createOriginIfNotExists($name, string $medium_id)
    {
        if ($name) {
            return Origin::firstOrCreate(
                ['name' => $name, 'medium_id' => $medium_id],
                ['name' => $name, 'medium_id' => $medium_id]
            );
        }
    }

    public function validateCompaniesBrandParams(string $medium_id, $origin_id, string $brand_id, $state_id): void
    {
        Medium::where('id', $medium_id)->firstOrFail();
        Origin::where('id', $origin_id)->firstOrFail();
        Brand::where('id', $brand_id)->firstOrFail();
        State::where('id', $state_id)->firstOrFail();
    }

    public function getGroupsContracted(string $medium_id, string $company_id, array $brand_id): array
    {
        $companyBrandQuery = CompanyBrand
            ::whereIn('brand_id', $brand_id)
            ->where('medium_id', $medium_id)
            ->where('company_id', $company_id)
            ->with('companyBrandLocations.origin.group')
            ->get();

        $transformedArray = [];
        foreach ($companyBrandQuery as $item) {
            foreach ($item->companyBrandLocations as $group) {
                $groupId = $group->origin->group->id;
                $groupData = $group->origin->group;
                $originData = $group->origin;

                if (!isset($transformedArray[$groupId])) {
                    $transformedArray[$groupId] = [
                        'id' => $groupData->id,
                        'medium_id' => $groupData->medium_id,
                        'name' => $groupData->name,
                        'description' => $groupData->description,
                        'origins' => []
                    ];
                }

                unset($originData->group);
                $transformedArray[$groupId]['origins'][] = $originData;
            }
        }

        return $transformedArray;
    }

    public function getRegistersForRevista(string $medium_id, array $brands_id, array $origins_id, $date_start, $date_end)
    {
        $registerQuery = Register::whereIn('brand_id', $brands_id)
            ->whereIn('origin_id', $origins_id);

            if ($date_start && $date_end) {
                $registerQuery = $registerQuery
                    ->whereBetWeen('publicacion_date', [$date_start, $date_end]);
            }

            return $registerQuery->whereHas('origin', function ($query) use ($medium_id) {
                $query->where('medium_id', $medium_id);
            })
            ->with([
                'readedFile', 'state', 'insertion', 'supplier', 'category', 'brand', 'product', 'origin'
            ])
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function getRegistersForOOH(string $medium_id, array $brands_id, array $states_id, $date_start, $date_end)
    {
        $registerQuery = Register::whereIn('brand_id', $brands_id)
            ->whereIn('state_id', $states_id);

        if ($date_start && $date_end) {
            $registerQuery = $registerQuery
                ->whereBetWeen('publicacion_date', [$date_start, $date_end]);
        }

        return $registerQuery->whereHas('origin', function ($query) use ($medium_id) {
                    $query->where('medium_id', $medium_id);
                })
                ->with([
                    'readedFile', 'state', 'insertion', 'supplier', 'category', 'brand', 'product', 'origin'
                ])
                ->orderBy('id', 'ASC')
                ->get();
    }

    public function getRegistersForTV(string $medium_id, array $brands_id, array $origins_id, $date_start, $date_end)
    {
        $registerQuery = Register::whereIn('brand_id', $brands_id)
            ->whereIn('origin_id', $origins_id);

        if ($date_start && $date_end) {
            $registerQuery = $registerQuery
                ->whereBetWeen('publicacion_date', [$date_start, $date_end]);
        }

        return $registerQuery->whereHas('origin', function ($query) use ($medium_id) {
            $query->where('medium_id', $medium_id);
        })
            ->with([
                'readedFile', 'state', 'insertion', 'supplier', 'category', 'brand', 'product', 'origin.group'
            ])
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function getRegister(string | null $insertion_id, string | null $supplier_id, string | null $category_id, string | null $brand_id, string | null $state_id, string | null $product_id, string | null $origin_id, string | null $orientacion, string | null $testigo, string | null $page)
    {
        return Register::where('insertion_id', $insertion_id)
            ->where('supplier_id', $supplier_id)
            ->where('category_id', $category_id)
            ->where('brand_id', $brand_id)
            ->where('state_id', $state_id)
            ->where('product_id', $product_id)
            ->where('brand_id', $brand_id)
            ->where('origin_id', $origin_id)
            ->where('orientacion', $orientacion)
            ->where('testigo', $testigo)
            ->where('pagina', $page)
            ->first();
    }
}
