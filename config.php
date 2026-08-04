<?php
// Vueports Solutions — Configuration & Base Path
// Auto-detects the project root from any file location

$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$scriptDir = rtrim($scriptDir, '/');

// Determine how many levels deep we are
$depth = substr_count($scriptDir, '/');
$basePath = '';
for ($i = 0; $i < $depth; $i++) {
    $basePath .= '../';
}

// If we're at root level, basePath is empty or './'
if ($basePath === '') {
    $basePath = './';
}

// Also define absolute path for includes
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$scriptFile = $_SERVER['SCRIPT_FILENAME'];
$projectRoot = dirname($scriptFile);

// Walk up to find the project root (where index.php exists)
while ($projectRoot !== dirname($projectRoot)) {
    if (file_exists($projectRoot . '/index.php') && file_exists($projectRoot . '/includes/header.php')) {
        break;
    }
    $projectRoot = dirname($projectRoot);
}

define('BASE_PATH', $basePath);
define('ABS_PATH', $projectRoot . '/');
?>
