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
        Schema::create('registers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('readed_file_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('insertion_id');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('origin_id');
            $table->foreign('insertion_id')->references('id')->on('insertions')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categorys')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('origin_id')->references('id')->on('origins')->onDelete('cascade');
            $table->string('orientacion')->nullable();
            $table->string('pagina');
            $table->string('vista_posicion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('publicacion_date')->nullable();
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->string('state_name')->nullable();
            $table->string('mes');
            $table->string('version')->nullable();
            $table->string('testigo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
