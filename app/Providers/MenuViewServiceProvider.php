<?php

namespace App\Providers;

use App\Services\DashboardMenuService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class MenuViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Inertia::share('menu', fn () => Auth::user() ? $this->app->get(DashboardMenuService::class)->getDashboardMenu()->render() : null);
    }
}
