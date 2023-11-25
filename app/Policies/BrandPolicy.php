<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use App\Services\PermissionService;

class BrandPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_VIEW_BRANDS);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_CREATE_BRANDS);
    }

    public function update(User $user, Brand $brand): bool
    {
        return $user->can(PermissionService::PERMISSION_EDIT_BRANDS);
    }

    public function delete(User $user, Brand $brand): bool
    {
        return $user->can(PermissionService::PERMISSION_DELETE_BRANDS);
    }
}
