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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_items_id');
            $table->string('orders_id', 30);
            $table->string('products_id', 30);
            $table->integer('quantity');
            $table->string('variant', 20); // 200g, 500g, 1kg
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('orders_id')->references('orders_id')->on('orders')->onDelete('cascade');
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
