<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // This migration was originally incorrect and created a duplicate 'transactions' table.
        // It has been neutralized to avoid schema conflicts.
    }

    public function down(): void
    {
        // No rollback needed for neutralized migration.
    }
};
