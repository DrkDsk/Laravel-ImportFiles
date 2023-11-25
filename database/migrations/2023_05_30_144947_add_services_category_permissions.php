<?php

use App\Services\RoleService;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    private array $permissions = [
        'can view services category',
        'can create services category',
        'can edit services category',
        'can delete services category',
    ];

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
