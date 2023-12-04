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
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('id', true);
            $table->unsignedMediumInteger('category_id');
            $table->string('name', 80);
            $table->unsignedMediumInteger('price');
            $table->foreign('category_id')->references('id')->on('categories');
            // Sqlite does not support prefix indexes
            if (!app()->runningUnitTests()) {
                $table->rawIndex('name(28)','name');
            } else {
                $table->index('name');
            }
            $table->index('price', 'price');
        });

        Schema::create('products_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('id');
            $table->text('description');
            $table->foreign('id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_details');
        Schema::dropIfExists('products');
    }
};
