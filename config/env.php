<?php
// config/env.php

if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue;
        putenv($line);
    }
}

define('BASE_URL', 'http://localhost/Vueports/');
define('SITE_NAME', 'Vueports Solutions');

/**
 * Get environment variable with fallback
 */
function env(string $key, string $default = ''): string {
    $value = getenv($key);
    return $value !== false ? $value : $default;
}