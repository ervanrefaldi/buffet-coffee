<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$e = \App\Models\Event::where('title', 'like', '%indo%')->orderBy('created_at', 'desc')->first();

if ($e) {
    echo "Found Event: " . $e->title . "\n";
    echo "Raw DB Image: [" . $e->image . "]\n";
    echo "Computed URL: " . $e->image_url . "\n";
    
    $localPath = storage_path('app/public/' . $e->image);
    $publicPath = public_path('storage/' . $e->image);
    
    echo "Checking Local Path: " . $localPath . " -> " . (file_exists($localPath) ? "EXISTS" : "MISSING") . "\n";
    echo "Checking Public Path: " . $publicPath . " -> " . (file_exists($publicPath) ? "EXISTS" : "MISSING") . "\n";
    
    if (file_exists($localPath) && !file_exists($publicPath)) {
        echo "WARNING: File exists in storage but symlink is broken.\n";
    }
} else {
    echo "Event not found.\n";
}
