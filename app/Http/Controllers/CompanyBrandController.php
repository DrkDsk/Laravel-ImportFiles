<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyBrandRequest;
use App\Http\Resources\GeneralResource;
use App\Models\Company;
use App\Models\CompanyBrand;
use App\Models\CompanyBrandLocation;
use App\Models\Origin;
use App\Repositorys\GeneralRepository;
use Illuminate\Support\Facades\Auth;

class CompanyBrandController extends Controller
{
    public function __construct(private readonly GeneralRepository $generalRepository)
    {

    }

    public function store (CreateCompanyBrandRequest $request): GeneralResource
    {
        $company_id = Auth::user()->company_id;

        $medium_id = $request->validated('medium_id');
        $brand_id  = $request->validated('brand_id');
        $origin_id = $request->origin_id;
        $state_id  = $request->state_id;

        $this->generalRepository->validateCompaniesBrandParams($medium_id, $origin_id, $brand_id, $state_id);

        if ($origin_id) {
            $origin = Origin::where('id', $origin_id)->first();
            $medium = $origin->medium;
            $medium_id = $medium ? $medium->id : null;
        }

        $companyBrand = CompanyBrand::firstOrCreate(
            [
                'brand_id'   => $brand_id,
                'medium_id'  => $medium_id,
                'company_id' => $company_id
            ],
            [
                'brand_id'   => $brand_id,
                'medium_id'  => $medium_id,
                'company_id' => $company_id
            ]
        );

        $companyBrandLocation = CompanyBrandLocation::where('company_brand_id', $companyBrand->id)
            ->where('state_id', $state_id)
            ->where('origin_id', $origin_id)
            ->first();

        if ($companyBrandLocation) {
            return (new GeneralResource($companyBrandLocation))->additional([
                'message' => 'Este contrato ya está registrado'
            ]);
        }

        $companyBrandLocation = CompanyBrandLocation::create([
            'company_brand_id'   => $companyBrand->id,
            'state_id'           => $state_id,
            'origin_id'          => $origin_id
        ]);

        return (new GeneralResource($companyBrandLocation));
    }
}
