<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Policies\BrandPolicy;
use App\Policies\ServicePolicy;
use App\Policies\ServicesCategoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => ServicesCategoryPolicy::class,
        Brand::class => BrandPolicy::class,
        User::class => UserPolicy::class,
        Service::class => ServicePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
