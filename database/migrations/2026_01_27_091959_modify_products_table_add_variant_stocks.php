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
        Schema::table('products', function (Blueprint $table) {
            // Drop old shared stock
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }

            // Add separate stock columns
            $table->integer('stock_200g')->default(0)->after('description');
            $table->integer('stock_500g')->default(0)->after('stock_200g');
            $table->integer('stock_1kg')->default(0)->after('stock_500g');

            // Add coffee variant
            $table->enum('coffee_variant', ['robusta', 'arabica'])->default('robusta')->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('stock', 10, 2)->default(0);
            $table->dropColumn(['stock_200g', 'stock_500g', 'stock_1kg']);
            $table->dropColumn('coffee_variant');
        });
    }
};
