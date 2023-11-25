<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBrandsRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\FileSystemService;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class BrandsController extends Controller
{

    public function __construct(protected readonly FileSystemService $fileSystemService)
    {
        $this->authorizeResource(Brand::class);
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard/Brands/Index', [
            "baseUrl" => url(''),
            "brands" => Brand::all()->map(function ($brand) {
                $brand->image = $brand->fullImagePath;
                return $brand;
            })
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Brands/Create');
    }

    public function store(CreateBrandsRequest $request): RedirectResponse
    {
        Brand::query()->create([
            "name" => $request->validated('name'),
            "title" => $request->validated('title'),
            "description" => $request->get('description'),
            "image" => $this->fileSystemService->store(Brand::PATH_BRAND_IMAGE)
        ]);

        return redirect()->route('dashboard.brands.index');
    }

    public function edit(Brand $brand): Response
    {
        return Inertia::render('Dashboard/Brands/Edit', [
            "brand" => $brand
        ]);
    }

    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $image = $this->fileSystemService->store(Brand::PATH_BRAND_IMAGE);
            if ($brand->image) {
                $this->fileSystemService->delete($brand->image);
            }

            $brand->update(["image" => $image]);
        }

        $brand->update([
            "title" => $request->validated('title'),
            "description" => $request->get('description')
        ]);

        return redirect()->route('dashboard.brands.index');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $this->fileSystemService->delete($brand->image);
        $brand->delete();

        return redirect()->route('dashboard.brands.index');
    }
}
