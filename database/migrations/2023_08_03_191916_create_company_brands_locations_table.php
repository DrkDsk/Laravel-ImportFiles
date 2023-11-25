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
        Schema::create('company_brands_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_brand_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('origin_id')->nullable();
            $table->foreign('company_brand_id')->references('id')->on('companies_brands');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('origin_id')->references('id')->on('origins');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_brands_locations');
    }
};
