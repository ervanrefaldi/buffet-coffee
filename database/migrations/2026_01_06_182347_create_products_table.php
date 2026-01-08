<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            // Primary Key dari trigger
            $table->string('products_id', 30)->primary();

            // Data produk
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('weight_kg', 10, 2);
            $table->integer('stock');

            // Kategori produk
            $table->enum('category', ['biji', 'bubuk']);

            // ⬅⬅⬅ INI PENTING
            $table->string('image', 255); // nama file / path gambar

            // Timestamp
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
