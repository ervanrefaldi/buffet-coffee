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
            
            // Stok (Shared across variants) in Kg
            $table->decimal('stock', 10, 2)->default(0);

            // Harga per varian berat
            $table->decimal('price_200g', 10, 2);
            $table->decimal('price_500g', 10, 2);
            $table->decimal('price_1kg', 10, 2);

            // Kategori produk (Jenis Kopi)
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
