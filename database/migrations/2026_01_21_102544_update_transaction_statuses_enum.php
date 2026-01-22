<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Change to VARCHAR temporarily
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(50)");

        // 2. Update data
        DB::table('transactions')->where('status', 'created')->update(['status' => 'dibayar']);
        DB::table('transactions')->where('status', 'confirmed')->update(['status' => 'diproses']);
        DB::table('transactions')->where('status', 'completed')->update(['status' => 'selesai']);

        // 3. Change back to new ENUM
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('dibayar', 'diproses', 'dikirim', 'selesai') DEFAULT 'dibayar'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(50)");
        DB::table('transactions')->where('status', 'dibayar')->update(['status' => 'created']);
        DB::table('transactions')->where('status', 'diproses')->update(['status' => 'confirmed']);
        DB::table('transactions')->where('status', 'selesai')->update(['status' => 'completed']);
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('created', 'confirmed', 'completed') DEFAULT 'created'");
    }
};
