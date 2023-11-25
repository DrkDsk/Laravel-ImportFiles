<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use App\Services\PermissionService;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_VIEW_SERVICES);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_CREATE_SERVICES);
    }

    public function update(User $user, Service $service): bool
    {
        return $user->can(PermissionService::PERMISSION_EDIT_SERVICES);
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->can(PermissionService::PERMISSION_DELETE_SERVICES);
    }
}
