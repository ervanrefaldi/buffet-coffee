<?php

use App\Models\Product;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing Product Creation...\n";

try {
    DB::beginTransaction();

    $product = Product::create([
        'name' => 'Test Coffee',
        'category' => 'biji',
        'stock' => 10,
        'price_200g' => 50000,
        'price_500g' => 120000,
        'price_1kg' => 200000,
        'description' => 'Test description',
        'image' => 'images/products/test.jpg'
    ]);

    echo "Product created successfully: " . $product->products_id . "\n";
    
    DB::rollBack(); // Don't actually save it
    echo "Rolled back transaction.\n";

} catch (\Exception $e) {
    echo "Error creating product: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
