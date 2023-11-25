<?php

namespace App\Policies;

use App\Models\User;
use App\Services\PermissionService;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_VIEW_USERS);
    }

    public function create(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_CREATE_USERS);
    }

    public function update(User $loggedUser, User $user): bool
    {
        return $loggedUser->can(PermissionService::PERMISSION_EDIT_USERS);
    }

    public function delete(User $loggedUser, User $user): bool
    {
        return $loggedUser->can(PermissionService::PERMISSION_DELETE_USERS);
    }
}
