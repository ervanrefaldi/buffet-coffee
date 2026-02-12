$products = App\Models\Product::where('name', 'like', '%NATURAL%')->get();
foreach($products as $p) {
    echo "ID: " . $p->id . "\n";
    echo "Name: " . $p->name . "\n";
    echo "Image: " . $p->image . "\n";
    $storage = storage_path('app/public/' . $p->image);
    echo "Storage Path: " . $storage . "\n";
    echo "Exists locally: " . (file_exists($storage) ? 'YES' : 'NO') . "\n";
    $publicLink = public_path('storage/' . $p->image);
    echo "Public Link Path: " . $publicLink . "\n";
    echo "Exists public link: " . (file_exists($publicLink) ? 'YES' : 'NO') . "\n";
}
exit;
