<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {

            /*
             |--------------------------------------------------
             | PRIMARY KEY (DIISI OLEH TRIGGER)
             | Format: EVT-XXX-070126-001
             |--------------------------------------------------
             */
            $table->string('events_id', 40)->primary();

            /*
             |--------------------------------------------------
             | DATA UTAMA EVENT
             |--------------------------------------------------
             */
            $table->string('title', 150);
            $table->text('description');
            $table->string('image', 255);

            /*
             |--------------------------------------------------
             | RENTANG TANGGAL EVENT
             |--------------------------------------------------
             */
            $table->date('start_date');
            $table->date('end_date');

            /*
             |--------------------------------------------------
             | TIMESTAMP
             |--------------------------------------------------
             */
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }

};
