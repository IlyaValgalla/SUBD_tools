<?php

echo "=== SSL Certificate Check ===\n\n";

// Проверяем разные возможные пути
$paths = [
    __DIR__ . '/ssl/cacert.pem',
    "C:\Илья\Универ\605-11\СУБД\PhpstormProjects\kie60511\ssl\cacert.pem",
    __DIR__ . '\ssl\cacert.pem' // Windows путь
];

foreach ($paths as $path) {
    echo "Checking: " . $path . "\n";
    echo "Exists: " . (file_exists($path) ? 'YES ✅' : 'NO ❌') . "\n";
    if (file_exists($path)) {
        echo "Size: " . filesize($path) . " bytes\n";
        echo "Readable: " . (is_readable($path) ? 'YES ✅' : 'NO ❌') . "\n";
    }
    echo "---\n";
}

// Проверяем папку ssl
$sslDir = __DIR__ . '/ssl';
echo "SSL directory: " . $sslDir . "\n";
echo "Directory exists: " . (is_dir($sslDir) ? 'YES ✅' : 'NO ❌') . "\n";

if (is_dir($sslDir)) {
    $files = scandir($sslDir);
    echo "Files in ssl directory: " . implode(', ', $files) . "\n";
}

echo "\nIf no SSL certificates found, run: php download-ssl.php\n";
