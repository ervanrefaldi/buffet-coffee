<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = \App\Models\User::create([
        'name' => 'Test Admin',
        'email' => 'testadmin'. rand(100,999) .'@example.com',
        'password' => bcrypt('password'),
        'phone' => '081234567890',
        'role' => 'admin'
    ]);
    echo "SUCCESS: User created with ID " . $user->users_id;
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString();
}
