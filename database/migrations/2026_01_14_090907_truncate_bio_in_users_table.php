<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Truncate bio to max 20 characters
        DB::statement('UPDATE users SET bio = LEFT(bio, 20) WHERE LENGTH(bio) > 20');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse truncate
    }
};
