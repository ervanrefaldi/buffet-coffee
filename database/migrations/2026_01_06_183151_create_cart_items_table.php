<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {

            // Primary Key (dari trigger)
            $table->string('cart_items_id', 30)->primary();

            // Relasi ke carts
            $table->string('carts_id', 30);

            // Relasi ke products
            $table->string('products_id', 30);

            // Data item
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);

            // Foreign Key
            $table->foreign('carts_id')
                  ->references('carts_id')
                  ->on('carts');

            $table->foreign('products_id')
                  ->references('products_id')
                  ->on('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }

};
