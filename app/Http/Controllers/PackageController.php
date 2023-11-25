<?php

namespace App\Http\Controllers;

use App\Factories\PackageCompanyFactory;
use App\Factories\PackageFactory;
use App\Http\Requests\CreatePackageRequest;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class PackageController extends Controller
{
    public function __construct(
        protected PackageFactory $packageFactory,
        protected PackageCompanyFactory $packageCompanyFactory)
    {
    }

    public function index(): Response
    {
        $packages = $this->packageFactory->getAllPackages();

        return Inertia::render('Dashboard/Packages/Index', [
            'packages' => $packages
        ]);
    }

    public function edit(Package $package)
    {
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Packages/Create');
    }

    public function store(CreatePackageRequest $request): RedirectResponse
    {
        $authCompanyId = Auth::user()->company_id;
        $package = $this->packageFactory->store($request->validated());
        $this->packageCompanyFactory->store($package->id, $authCompanyId);

        return redirect()->route('dashboard.packages.index');
    }

}
