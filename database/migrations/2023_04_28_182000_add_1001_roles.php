<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'administrador']);
        Role::create(['name' => 'cliente']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::findByName('administrador')->delete();
        Role::findByName('cliente')->delete();
    }
};
