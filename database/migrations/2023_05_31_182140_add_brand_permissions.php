<?php

use App\Services\RoleService;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    private array $permissions = [
        'can view brands',
        'can create brands',
        'can edit brands',
        'can delete brands'
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::findByName(RoleService::ROLE_ADMINISTRATOR);
        $admin->givePermissionTo($this->permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $admin = Role::findByName(RoleService::ROLE_ADMINISTRATOR);
        $admin->revokePermissionTo($this->permissions);

        foreach ($this->permissions as $permission) {
            Permission::findByName($permission)->delete();
        }
    }
};
