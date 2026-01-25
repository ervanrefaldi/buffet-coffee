<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('users_id', 20)->primary(); // USR-02-060126-001
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255); // HASH password
            $table->string('phone', 20)->nullable();
            $table->enum('role', ['owner', 'pelanggan', 'membership', 'admin']);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
