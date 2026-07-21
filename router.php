<?php
// router.php - handles clean URLs for PHP built-in server
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = __DIR__ . $uri;

if (file_exists($path) && is_file($path)) {
    return false; // serve the file directly
}

require __DIR__ . '/index.php'; // fallback to index.php
?>
