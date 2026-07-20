<?php
declare(strict_types=1);
// monitoring/health-check.php — System Health Monitor

require_once '../includes/functions.php';

header('Content-Type: application/json');

$checks = [];
$healthy = true;
$start = microtime(true);

// ── DATABASE ──
try {
    $db = db();
    $db->query('SELECT 1');
    $checks['database'] = ['status' => 'ok', 'latency_ms' => round((microtime(true) - $start) * 1000, 2)];
} catch (Throwable $e) {
    $checks['database'] = ['status' => 'error', 'message' => $e->getMessage()];
    $healthy = false;
}

// ── DISK SPACE ──
$diskTotal = disk_total_space(__DIR__);
$diskFree = disk_free_space(__DIR__);
$diskUsed = $diskTotal - $diskFree;
$diskPct = round(($diskUsed / $diskTotal) * 100, 1);
$checks['disk'] = [
    'status' => $diskPct > 90 ? 'warning' : 'ok',
    'used_percent' => $diskPct,
    'free_gb' => round($diskFree / 1073741824, 2)
];
if ($diskPct > 95) $healthy = false;

// ── PHP EXTENSIONS ──
$required = ['pdo', 'pdo_mysql', 'openssl', 'json', 'mbstring', 'fileinfo'];
$missing = array_filter($required, fn($ext) => !extension_loaded($ext));
$checks['php_extensions'] = [
    'status' => empty($missing) ? 'ok' : 'error',
    'required' => $required,
    'missing' => array_values($missing)
];
if (!empty($missing)) $healthy = false;

// ── MEMORY ──
$memUsage = memory_get_usage(true);
$memLimit = ini_get('memory_limit');
$checks['memory'] = [
    'status' => 'ok',
    'usage_mb' => round($memUsage / 1048576, 2),
    'limit' => $memLimit
];

// ── WRITE PERMISSIONS ──
$writablePaths = ['../logs', '../cache', '../uploads'];
$writeIssues = [];
foreach ($writablePaths as $path) {
    if (!is_dir($path) || !is_writable($path)) {
        $writeIssues[] = $path;
    }
}
$checks['write_permissions'] = [
    'status' => empty($writeIssues) ? 'ok' : 'warning',
    'paths' => $writablePaths,
    'issues' => $writeIssues
];
if (!empty($writeIssues)) $healthy = false;

// ── SSL CERTIFICATE (if HTTPS) ──
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $checks['ssl'] = ['status' => 'ok', 'protocol' => $_SERVER['HTTPS']];
} else {
    $checks['ssl'] = ['status' => 'warning', 'protocol' => 'HTTP'];
}

// ── ENV FILE ──
$checks['env'] = ['status' => file_exists('../.env') ? 'ok' : 'warning', 'file' => '../.env'];

// ── RESPONSE ──
http_response_code($healthy ? 200 : 503);
echo json_encode([
    'status' => $healthy ? 'healthy' : 'unhealthy',
    'timestamp' => date('c'),
    'version' => '1.0.0',
    'checks' => $checks
]);