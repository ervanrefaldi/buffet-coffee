<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Models\Product::all();
foreach($products as $p) {
    echo "ID: " . $p->products_id . " | Name: " . $p->name . " | Image: " . ($p->image ?? 'NULL') . PHP_EOL;
}
