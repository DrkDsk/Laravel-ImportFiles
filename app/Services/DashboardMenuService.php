<?php

namespace App\Services;

use App\Models\Medium;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Menu\Menu;

class DashboardMenuService
{
    private const SHARED_MENU_NAME = 'menu';

    public function getDashboardMenu(): Menu
    {
        $user = Auth::user();
        $mediums = Medium::all()->pluck('name', 'id');
        $submenu = Menu::new();
        foreach ($mediums as $id => $medium) {
            $submenu->link(route('dashboard.medium', $id ), ucfirst(strtolower($medium)));
        }

        $menu = Menu::new()
            ->link(route('dashboard.index'), 'Dashboard')
            ->linkIf($user->can(PermissionService::PERMISSION_CREATE_SERVICES), route('dashboard.packages.index'), 'Paquetes')
            ->linkIf($user->can(PermissionService::PERMISSION_VIEW_USERS), route('dashboard.users.index'), 'Usuarios')
            ->linkIf($user->can(PermissionService::PERMISSION_VIEW_BRANDS), route('dashboard.brands.index'), 'Marcas')
            ->linkIf(
                $user->can(PermissionService::PERMISSION_VIEW_SERVICES_CATEGORY),
                route('dashboard.category.index'),
                'Categoría de Servicios'
            )
            ->link(route('dashboard.files.index'), 'Importación de Archivos')
            ->link(route('dashboard.report.index'), 'Medios contratados')
            ->link(route('dashboard.fileExport.index'), 'Archivos a exportar')
            ->submenu('<span class="text-white ml-3">Reportes</span>',
                $submenu
            );

        return $this->addMarkup($menu);
    }

    private function addMarkup(Menu $menu): Menu
    {
        $menu->addItemClass(
            'list-none flex flex-col px-2 py-2 mt-2 duration-200 border-l-4 text-white border-gray-900'
        );

        return $menu;
    }

    public function compose(View $view): void
    {
        $view->with(self::SHARED_MENU_NAME, $this->getDashboardMenu());
    }
}
