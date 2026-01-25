<?php

use Illuminate\Support\Facades\DB;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel...
$app = require_once __DIR__.'/../bootstrap/app.php';

// Create a kernel to bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<h1>Database & Trigger Fixer v2</h1>";
    $pdo = DB::connection()->getPdo();

    // 1. FIX ENUM (Just in case)
    echo "<p>1. Updating Role ENUM...</p>";
    $pdo->exec("ALTER TABLE users MODIFY COLUMN role ENUM('owner', 'pelanggan', 'membership', 'admin') NOT NULL");
    echo "<span style='color:green'>Done.</span><br>";

    // 2. FIX TRIGGER
    echo "<p>2. Updating ID Generation Trigger...</p>";
    
    // Drop old trigger
    $pdo->exec("DROP TRIGGER IF EXISTS trg_users_generate_id");
    
    // Create new trigger with ADMIN support (Code 04)
    $triggerSql = "
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

            -- Jika role_code masih null (misal ada role baru yg belum dihandle), set default
            IF role_code IS NULL THEN
                 SET role_code = 'XX';
            END IF;

            -- Ambil tanggal dari created_at (DDMMYY)
            -- Jika created_at null, pakai NOW()
            IF NEW.created_at IS NULL THEN
                SET NEW.created_at = NOW();
            END IF;
            
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
    ";
    
    $pdo->exec($triggerSql);
    echo "<span style='color:green'>Trigger updated successfully!</span><br>";

    echo "<hr>";
    echo "<h2 style='color: green;'>ALL SYSTEMS FIXED!</h2>";
    echo "<p>Sekarang coba buat akun ADMIN lagi. Seharusnya sudah berhasil.</p>";
    echo "<p><strong>PENTING:</strong> Segera hapus file <code>fix_v2.php</code> ini dari server Anda.</p>";

} catch (\Exception $e) {
    echo "<h2 style='color: red;'>ERROR</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
