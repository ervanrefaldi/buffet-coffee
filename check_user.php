<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('role', 'admin')->first();
if ($user) {
    echo "FOUND: " . $user->name . " | " . $user->email . " | " . $user->role . "\n";
} else {
    echo "NOT FOUND\n";
}
