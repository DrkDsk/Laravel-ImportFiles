<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Service;
use Inertia\Inertia;

class CategoryServicesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Service::class);
    }

    public function index(Category $category)
    {
        return Inertia::render(
            'Dashboard/Categories/Services/Index',
            [
                'category' => $category,
                'servicesCollection' => Service::query()->with(['brand', 'category'])->paginate()
            ]
        );
    }

    public function create(Category $category)
    {
        return Inertia::render(
            'Dashboard/Categories/Services/Create',
            [
                'brandsCollection' => Brand::query()->paginate(),
                'category' => $category
            ]
        );
    }

    public function store(CreateServiceRequest $request, Category $category)
    {
        $category->services()->create($request->validated());

        return redirect()->route('dashboard.category.services.index', $category);
    }

    public function edit(Service $service)
    {
        return Inertia::render(
            'Dashboard/Categories/Services/Edit',
            [
                'brandsCollection' => Brand::query()->paginate(),
                'service' => $service
            ]
        );
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return redirect()->route('dashboard.category.services.index', $service->category_id);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('dashboard.category.services.index', $service->category_id);
    }
}
