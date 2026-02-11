<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$events = \App\Models\Event::all();
foreach($events as $e) {
    if (strpos($e->image, 'http') === false) {
       // Local image check
       $exists = file_exists(storage_path('app/public/' . $e->image)) ? 'YES' : 'NO';
       echo "Local: {$e->image} | Exists: {$exists}\n";
    } else {
       echo "Remote: {$e->image}\n";
    }
}
