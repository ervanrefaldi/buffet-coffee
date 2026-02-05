<?php
// ImgBB API Test Script
// Run this via: php test_imgbb.php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

echo "--- ImgBB API Test ---\n";

$apiKey = config('services.imgbb.key') ?? env('IMGBB_API_KEY');

if (!$apiKey) {
    echo "ERROR: API Key not found in config or .env!\n";
    exit;
}

echo "API Key found: " . substr($apiKey, 0, 4) . "..." . substr($apiKey, -4) . "\n";

// Use a tiny transparent pixel for testing
$pixel = "R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

echo "Attempting test upload to ImgBB...\n";

try {
    $response = Http::withoutVerifying()->asForm()->post('https://api.imgbb.com/1/upload', [
        'key' => $apiKey,
        'image' => $pixel,
    ]);

    if ($response->successful()) {
        $url = $response->json()['data']['url'] ?? null;
        echo "SUCCESS! Image uploaded.\n";
        echo "URL: " . $url . "\n";
    } else {
        echo "FAILED!\n";
        echo "Status: " . $response->status() . "\n";
        echo "Response: " . $response->body() . "\n";
    }
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
