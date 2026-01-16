<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared("
        CREATE TRIGGER trg_events_generate_id
        BEFORE INSERT ON events
        FOR EACH ROW
        BEGIN
            DECLARE date_code CHAR(6);
            DECLARE seq INT;
            DECLARE seq_formatted CHAR(3);

            -- Ambil tanggal dari created_at (DDMMYY)
            SET date_code = DATE_FORMAT(NEW.created_at, '%d%m%y');

            -- Hitung urutan event berdasarkan tanggal
            SELECT COUNT(*) + 1
            INTO seq
            FROM events
            WHERE DATE(created_at) = DATE(NEW.created_at);

            -- Format urutan 3 digit
            SET seq_formatted = LPAD(seq, 3, '0');

            -- Generate events_id: EVT-001-DDMMYY-XXX
            SET NEW.events_id = CONCAT(
                'EVT-001-', date_code, '-', seq_formatted
            );
        END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_events_generate_id");
    }
};
