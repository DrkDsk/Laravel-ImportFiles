<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('file_exports', function (Blueprint $table) {
            $table->unsignedBigInteger('medium_id')->after('id');
            $table->json('data')->nullable()->after('medium_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_exports', function (Blueprint $table) {
            //
        });
    }
};
