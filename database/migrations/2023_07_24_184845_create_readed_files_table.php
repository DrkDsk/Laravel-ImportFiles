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
        Schema::create('readed_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fileName');
            $table->string('origin');
            $table->timestamp('start')->nullable();
            $table->timestamp('finish')->nullable();
            $table->double('count')->nullable();
            $table->text('exception')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readed_files');
    }
};
