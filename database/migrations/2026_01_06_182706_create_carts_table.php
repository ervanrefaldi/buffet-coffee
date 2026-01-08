<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {

            // Primary Key (dibuat oleh trigger)
            $table->string('carts_id', 30)->primary();

            // Relasi ke users
            $table->string('user_id', 20);

            // Waktu pembuatan cart
            $table->dateTime('created_at');

            // Foreign Key
            $table->foreign('user_id')
                  ->references('users_id')
                  ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }

};
