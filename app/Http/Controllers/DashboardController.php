<?php

namespace App\Http\Controllers;

use App\Enums\TypeOfMedium;
use App\Models\Medium;
use App\Models\User;
use App\Repositorys\CompanyBrandRepository;
use App\Services\CompanyBrandsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{

    public function __construct(
        protected CompanyBrandsService $companyBrandsService,
        protected CompanyBrandRepository $companyBrandRepository)
    {
    }

    public function index(): Response
    {
        $packagesContracted = $this->companyBrandRepository->getAllContractedBrands();
        $brandsContracted   = $this->companyBrandsService->filterCompanyBrandsFromPackagesCompanies($packagesContracted);

        return Inertia::render('Dashboard', [
            'brands' => $brandsContracted
        ]);
    }

    public function show(Medium $medium, Request $request)
    {
        $packagesByMedium  = $this->companyBrandRepository->getPackagesCompanyByMedium($medium->id) ?? [];
        $brandsContracted  = $this->companyBrandsService->filterCompanyBrandsFromPackagesCompanies($packagesByMedium);

        if ($medium->name == strtoupper(TypeOfMedium::Revista->value)) {
            return Inertia::render('Dashboard/Reports/Magazines/Index', [
                "brands" => $brandsContracted,
                "baseUrl" => url(''),
                "medium" => $medium,
            ]);
        }

        if ($medium->name == strtoupper(TypeOfMedium::OOH->value)) {
            return Inertia::render("Dashboard/Reports/OOH/Index", [
                "brands" => $brandsContracted,
                "baseUrl" => url(''),
                "medium" => $medium,
                "usersList" => User::when($request->term, function ($query, $term) {
                    $query->where('name', "LIKE", '%' . $term . '%');
                })->paginate(6)
            ]);
        }

        if ($medium->name == strtoupper(TypeOfMedium::Prensa->value)) {
            return Inertia::render("Dashboard/Reports/Prensa/Index", [
                "brands" => $brandsContracted,
                "baseUrl" => url(''),
                "medium" => $medium,
            ]);
        }
    }
}
