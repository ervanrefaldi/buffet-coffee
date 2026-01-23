<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fix: Change user_id from unsigned bigint (foreignId) to string 
     * to match users table primary key (users_id is varchar/string)
     */
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Drop the existing user_id column and recreate as string
            $table->dropColumn('user_id');
        });

        Schema::table('sessions', function (Blueprint $table) {
            // Recreate user_id as string to match users.users_id
            $table->string('user_id', 20)->nullable()->after('id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->index();
        });
    }
};
