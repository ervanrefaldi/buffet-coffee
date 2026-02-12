try {
    $products = \App\Models\Product::where('name', 'LIKE', '%NATURAL%')->get();
    foreach($products as $p) {
        echo "ID: " . $p->products_id . "\n";
        echo "Image: " . $p->image . "\n";
        if (filter_var($p->image, FILTER_VALIDATE_URL)) {
             echo "Is URL: YES\n";
        } else {
             echo "Is URL: NO\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
exit();
