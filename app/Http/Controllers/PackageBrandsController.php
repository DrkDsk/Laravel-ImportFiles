<?php

namespace App\Http\Controllers;

use App\Enums\TypeOfMedium;
use App\Http\Requests\CreatePackageBrandRequest;
use App\Models\Package;
use App\Repositorys\BrandRepository;
use App\Repositorys\MediumRepository;
use App\Repositorys\StatesRepository;
use App\Services\CompanyBrandsService;
use App\Services\OriginService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PackageBrandsController extends Controller
{
    public function __construct(
        protected CompanyBrandsService $companyBrandsService,
        protected OriginService $originService,
        protected MediumRepository $mediumRepository,
        protected StatesRepository $statesRepository,
        protected BrandRepository $brandRepository)
    {
    }

    public function create(Package $package): Response
    {
        $brands = $this->brandRepository->getAll();
        $states = $this->statesRepository->getAll();
        $mediums = $this->mediumRepository->getAll();
        $origins = $this->originService->getOriginsByMediums($mediums);

        return Inertia::render('Dashboard/Packages/Brands/Create', [
            'package' => $package,
            'brands'  => $brands,
            'states'  => $states,
            'origins' => $origins,
            'mediums' => $mediums,
            'packageBrands' => $package->companiesBrands
        ]);
    }

    public function store(Package $package, CreatePackageBrandRequest $request) : RedirectResponse
    {
        $brand_id = $request->get('brand_id');

        if ($request->validated('isSelectedOOH')) {
            $this->companyBrandsService->hireServiceOOH($package->id, $brand_id, $request->get('state_ids'));
        }

        if ($request->validated('isSelectedRevista')) {
            $this->companyBrandsService->hireServiceOrigins($package->id, $brand_id, $request->get('magazine_ids'), TypeOfMedium::Revista->value);
        }

        if ($request->validated('isSelectedPrensa')) {
            $this->companyBrandsService->hireServiceOrigins($package->id, $brand_id, $request->get('newsPapers_ids'), TypeOfMedium::Prensa->value);
        }

        return redirect()->back();
    }
}
