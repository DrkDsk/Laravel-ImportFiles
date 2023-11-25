<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Services\PermissionService;

class ServicesCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_VIEW_SERVICES_CATEGORY);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can(PermissionService::PERMISSION_CREATE_SERVICES_CATEGORY);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user, Category $servicesCategory): bool
    {
        return $user->can(PermissionService::PERMISSION_EDIT_SERVICES_CATEGORY);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user, Category $servicesCategory): bool
    {
        return $user->can(PermissionService::PERMISSION_DELETE_SERVICES_CATEGORY);
    }
}
