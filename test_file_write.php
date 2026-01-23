<?php
$targetDir = __DIR__ . '/public/images/products';
$targetFile = $targetDir . '/test_write.txt';

echo "Testing write to: $targetDir\n";

if (!is_dir($targetDir)) {
    echo "Directory does not exist. Attempting to create...\n";
    if (mkdir($targetDir, 0777, true)) {
        echo "Directory created successfully.\n";
    } else {
        echo "Failed to create directory.\n";
        exit(1);
    }
}

if (file_put_contents($targetFile, "Test write content")) {
    echo "File write successful.\n";
    unlink($targetFile);
    echo "Test file cleaned up.\n";
} else {
    echo "File write failed.\n";
    exit(1);
}
