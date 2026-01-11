<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            /*
             |--------------------------------------------------
             | PRIMARY KEY (akan diisi oleh trigger)
             |--------------------------------------------------
             */
            $table->string('orders_id', 30)->primary();

            /*
             |--------------------------------------------------
             | RELASI KE USER
             |--------------------------------------------------
             */
            $table->string('user_id', 20);

            /*
             |--------------------------------------------------
             | ORDER CODE (UNTUK USER & WHATSAPP)
             |--------------------------------------------------
             */
            $table->string('order_code', 50)->unique();

            /*
             |--------------------------------------------------
             | RINGKASAN PESANAN
             |--------------------------------------------------
             */
            $table->decimal('total_price', 10, 2);
            $table->decimal('total_weight', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();

            /*
             |--------------------------------------------------
             | ALAMAT PENGIRIMAN
             |--------------------------------------------------
             */
            $table->text('shipping_address');

            /*
             |--------------------------------------------------
             | STATUS PESANAN
             |--------------------------------------------------
             */
            $table->enum('status', [
                'menunggu_pembayaran',
                'dibayar',
                'diproses',
                'selesai'
            ])->default('menunggu_pembayaran');

            /*
             |--------------------------------------------------
             | WAKTU ORDER
             |--------------------------------------------------
             */
            $table->dateTime('created_at');        // kapan order dibuat
            $table->dateTime('updated_at')->nullable(); // kapan terakhir diubah

            /*
             |--------------------------------------------------
             | FOREIGN KEY
             |--------------------------------------------------
             */
            $table->foreign('user_id')
                  ->references('users_id')
                  ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }

};
