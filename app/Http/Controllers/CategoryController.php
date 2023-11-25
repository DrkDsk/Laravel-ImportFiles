<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServicesCategoryRequest;
use App\Http\Requests\UpdateServicesCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index()
    {
        return Inertia::render(
            'Dashboard/Categories/Index',
            [
                'servicesCategories' => Category::query()->paginate()
            ]
        );
    }

    public function create()
    {
        return Inertia::render(
            'Dashboard/Categories/Create',
            ['servicesCategoryCollection' => Category::query()->paginate()]
        );
    }

    public function store(CreateServicesCategoryRequest $request)
    {
        Category::query()->create($request->validated());

        return Redirect::route('dashboard.category.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Dashboard/Categories/Edit', ['servicesCategory' => $category]);
    }

    public function update(UpdateServicesCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return Redirect::route('dashboard.category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return Redirect::route('dashboard.category.index');
    }
}
