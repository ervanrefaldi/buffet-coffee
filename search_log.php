<?php
$logPath = 'storage/logs/laravel.log';
if (file_exists($logPath)) {
    $f = fopen($logPath, 'r');
    while ($line = fgets($f)) {
        if (stripos($line, 'ImgBB') !== false) {
            echo $line;
        }
    }
    fclose($f);
} else {
    echo "Log file not found.";
}
