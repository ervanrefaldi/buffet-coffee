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
        // Change image column from VARCHAR to LONGBLOB to store actual file data
        // Using raw statement because Laravel blueprint helper for LONGBLOB varies by driver
        DB::statement("ALTER TABLE products MODIFY image LONGBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to VARCHAR (Warning: Data loss if binary data exceeds valid varchar length or chars)
        // We use TEXT first to be safe, or VARCHAR If sure.
        DB::statement("ALTER TABLE products MODIFY image VARCHAR(255)");
    }
};
