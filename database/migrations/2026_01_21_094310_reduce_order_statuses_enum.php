<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added for DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map existing statuses to the new ones
        DB::table('orders')->whereIn('status', ['diproses', 'selesai'])->update(['status' => 'dibayar']);

        // Update the enum
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['menunggu_pembayaran', 'dibayar'])->default('menunggu_pembayaran')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['menunggu_pembayaran', 'dibayar', 'diproses', 'selesai'])->default('menunggu_pembayaran')->change();
        });
    }
};
