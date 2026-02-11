<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$events = \App\Models\Event::all();
foreach($events as $e) { 
    echo "ID: " . $e->events_id . "\n";
    echo "Title: " . $e->title . "\n";
    echo "Image DB: " . $e->image . "\n";
    echo "Image URL: " . $e->image_url . "\n";
    echo "Storage exists: " . (file_exists(storage_path('app/public/' . $e->image)) ? 'YES' : 'NO') . "\n";
    echo "Public link exists: " . (file_exists(public_path('storage/' . $e->image)) ? 'YES' : 'NO') . "\n";
    echo "--------------------------------\n";
}
