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
            $table->uuid('id')->primary();
            $table->uuid('product_category_id');
            $table->uuid('store_id');
            $table->string('title');
            $table->string('thumbnail');
            $table->double('price')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->enum('validation', ['valid', 'invalid', 'pending'])->nullable();
            $table->text('validation_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
