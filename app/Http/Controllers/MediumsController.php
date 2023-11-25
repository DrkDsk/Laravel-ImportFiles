<?php

namespace App\Http\Controllers;

use App\Enums\TypeOfMedium;
use App\Http\Requests\GetContractedStatesRequest;
use App\Http\Resources\GeneralResource;
use App\Models\CompanyBrand;
use App\Models\Medium;
use App\Repositorys\CompanyBrandRepository;
use App\Repositorys\GeneralRepository;
use App\Services\CompanyBrandsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class MediumsController extends Controller
{
    public function __construct(
        protected CompanyBrandRepository $companyBrandRepository,
        protected CompanyBrandsService $companyBrandsService,
        protected  readonly GeneralRepository $generalRepository)
    {
    }

    public function index(): \Illuminate\Support\Collection
    {
        return Medium::all()->pluck('name', 'id');
    }

    public function show(Medium $medium, GetContractedStatesRequest $request): GeneralResource
    {
        if ($medium->name == strtoupper(TypeOfMedium::OOH->value)) {
            $companyBrands = $this->companyBrandRepository->getContractedBrandsOOH($request->validated('brands_id'), $medium);
            $states = $this->companyBrandsService->getStatesFromCompanyBrands($companyBrands);
            return (new GeneralResource($states));
        }

        if  ($medium->name == strtoupper(TypeOfMedium::Revista->value) || $medium->name == strtoupper(TypeOfMedium::Prensa->value)) {
            $companyBrands = $this->companyBrandRepository->getContractedBrandsForOrigins($request->validated('brands_id'), $medium);
            $origins     = $this->companyBrandsService->getOriginsFromCompanyBrands($companyBrands);
            return (new GeneralResource($origins));
        }

        if ($medium->name == strtoupper(TypeOfMedium::Television->value)) {
            $groupsWithChannels = $this->generalRepository->getGroupsContracted($medium->id, $company_id, $request->validated('brands_id'));
            return (new GeneralResource($groupsWithChannels));
        }

        return (new GeneralResource([]));
    }

    public function brands(): Collection|array
    {
        $company_id = Auth::user()->company_id;
        return CompanyBrand::query()->with('brand')->where('company_id', $company_id)->get();
    }
}
