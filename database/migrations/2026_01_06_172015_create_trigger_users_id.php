<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared("
        CREATE TRIGGER trg_users_generate_id
        BEFORE INSERT ON users
        FOR EACH ROW
        BEGIN
            DECLARE role_code CHAR(2);
            DECLARE date_code CHAR(6);
            DECLARE seq INT;
            DECLARE seq_formatted CHAR(3);

            -- Mapping role ke kode
            IF NEW.role = 'owner' THEN
                SET role_code = '01';
            ELSEIF NEW.role = 'pelanggan' THEN
                SET role_code = '02';
            ELSEIF NEW.role = 'membership' THEN
                SET role_code = '03';
            ELSEIF NEW.role = 'admin' THEN
                SET role_code = '04';
            END IF;

            -- Ambil tanggal dari created_at (DDMMYY)
            SET date_code = DATE_FORMAT(NEW.created_at, '%d%m%y');

            -- Hitung urutan user berdasarkan role + tanggal
            SELECT COUNT(*) + 1
            INTO seq
            FROM users
            WHERE role = NEW.role
              AND DATE(created_at) = DATE(NEW.created_at);

            -- Format urutan 3 digit
            SET seq_formatted = LPAD(seq, 3, '0');

            -- Generate users_id
            SET NEW.users_id = CONCAT(
                'USR-', role_code, '-', date_code, '-', seq_formatted
            );
        END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_users_generate_id");
    }
};
