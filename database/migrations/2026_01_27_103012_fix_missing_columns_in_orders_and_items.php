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
        // Fix Orders Table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'total_weight')) {
                    $table->decimal('total_weight', 10, 2)->default(0)->after('total_price');
                }
            });
        }

        // Fix Order Items Table
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'variant')) {
                    $table->string('variant', 20)->default('200g')->after('quantity');
                }
            });
        }
    }

    public function down(): void
    {
        // No down needed as this is a fix migration
    }
};
