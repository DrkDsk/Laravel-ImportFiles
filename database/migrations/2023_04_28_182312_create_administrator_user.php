<?php

use App\Models\User;
use App\Services\RoleService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'dev@bluestudio.mx',
        ]);

        $admin->assignRole(RoleService::ROLE_ADMINISTRATOR);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::query()->where('email', 'dev@bluestudio.mx')->delete();
    }
};
