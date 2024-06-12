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
        Schema::create('store_visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('store_id');
            $table->string('platform');
            $table->string('device');
            $table->string('ip');
            $table->string('province');
            $table->string('city');
            $table->string('user_agent');
            $table->enum('type', ['visitor', 'product', 'product-link', 'bio-link'])->default('visitor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_visitors');
    }
};
