<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Models\Product::where('name', 'LIKE', '%NATURAL%')->get();

foreach($products as $p) {
    echo "ID: " . $p->products_id . "\n";
    echo "Name: " . $p->name . "\n";
    echo "Image DB: " . $p->image . "\n";
    echo "Image URL Attr: " . $p->image_url . "\n";
    
    if (filter_var($p->image, FILTER_VALIDATE_URL)) {
        echo "Image is URL.\n";
    } else {
        echo "Image is Local Path.\n";
        echo "Storage Path: " . storage_path('app/public/' . $p->image) . "\n";
        echo "Exists locally: " . (file_exists(storage_path('app/public/' . $p->image)) ? 'YES' : 'NO') . "\n";
        echo "Public Link Path: " . public_path('storage/' . $p->image) . "\n";
        echo "Exists public link: " . (file_exists(public_path('storage/' . $p->image)) ? 'YES' : 'NO') . "\n";
    }
    echo "--------------------------------\n";
}
