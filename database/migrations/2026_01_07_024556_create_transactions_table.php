<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {

                /*
                 |--------------------------------------------------
                 | PRIMARY KEY (DIISI TRIGGER)
                 |--------------------------------------------------
                 */
                $table->string('transactions_id', 30)->primary();

                /*
                 |--------------------------------------------------
                 | RELASI KE ORDERS
                 |--------------------------------------------------
                 */
                $table->string('orders_id', 30);

                /*
                 |--------------------------------------------------
                 | KODE TRANSAKSI (UNTUK WHATSAPP)
                 |--------------------------------------------------
                 */
                $table->string('transaction_code', 100)->unique();

                /*
                 |--------------------------------------------------
                 | DATA PEMBAYARAN
                 |--------------------------------------------------
                 */
                $table->string('payment_method', 50)->nullable();

                /*
                 |--------------------------------------------------
                 | WAKTU TRANSAKSI & KONFIRMASI
                 |--------------------------------------------------
                 */
                $table->dateTime('transaction_date')->nullable(); // user bayar
                $table->dateTime('confirmed_at')->nullable();     // owner konfirmasi

                /*
                 |--------------------------------------------------
                 | STATUS TRANSAKSI
                 |--------------------------------------------------
                 */
                $table->enum('status', [
                    'created',
                    'confirmed',
                    'completed'
                ])->default('created');

                /*
                 |--------------------------------------------------
                 | WAKTU DATA DIBUAT
                 |--------------------------------------------------
                 */
                $table->dateTime('created_at');

                /*
                 |--------------------------------------------------
                 | FOREIGN KEY
                 |--------------------------------------------------
                 */
                $table->foreign('orders_id')
                      ->references('orders_id')
                      ->on('orders')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }

};
