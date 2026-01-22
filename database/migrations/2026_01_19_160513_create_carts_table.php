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
        Schema::create('carts', function (Blueprint $table) {
            $table->string('carts_id', 30)->primary();
            $table->string('user_id', 20);
            $table->string('products_id', 30);
            $table->integer('quantity');
            $table->string('variant', 20); // 200g, 500g, 1kg
            $table->timestamps();

            $table->foreign('user_id')->references('users_id')->on('users')->onDelete('cascade');
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
