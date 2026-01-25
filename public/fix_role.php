<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel...
$app = require_once __DIR__.'/../bootstrap/app.php';

// Create a kernel to bootstrap the application (needed for facades to work)
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<h1>Database Fixer</h1>";
    echo "<p>Attempting to add 'admin' role to users table...</p>";

    // Execute the ALTER TABLE command
    // Using raw PDO to bypass any potential Laravel listener issues
    DB::connection()->getPdo()->exec("ALTER TABLE users MODIFY COLUMN role ENUM('owner', 'pelanggan', 'membership', 'admin') NOT NULL");

    echo "<h2 style='color: green;'>SUCCESS!</h2>";
    echo "<p>Role 'admin' has been added to the database enum.</p>";
    echo "<p>You can now delete this file (fix_role.php) from your server and try creating an admin again.</p>";
    
    // Optional: Check if column actually updated
    $columns = DB::select("SHOW COLUMNS FROM users LIKE 'role'");
    if (!empty($columns)) {
        echo "<pre>";
        print_r($columns[0]);
        echo "</pre>";
    }

} catch (\Exception $e) {
    echo "<h2 style='color: red;'>ERROR</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
