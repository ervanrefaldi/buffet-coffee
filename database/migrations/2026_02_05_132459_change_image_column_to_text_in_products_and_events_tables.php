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
        // Menggunakan raw statement agar lebih aman tanpa doctrine/dbal
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE products MODIFY image TEXT");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE events MODIFY image TEXT");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE products MODIFY image LONGBLOB");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE events MODIFY image VARCHAR(255)");
    }
};
