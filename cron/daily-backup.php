<?php
declare(strict_types=1);
// cron/daily-backup.php — Automated Database & File Backup

require_once '../includes/functions.php';

// CLI only for security
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

$db = db();
if (!$db) exit('Database connection failed');

$backupDir = '../backups';
if (!is_dir($backupDir)) mkdir($backupDir, 0755, true);

$date = date('Y-m-d_H-i-s');
$sqlFile = "$backupDir/vueports_db_$date.sql";
$zipFile = "$backupDir/vueports_backup_$date.zip";

echo "[" . date('c') . "] Starting backup...\n";

// ── MYSQL DUMP ──
$env = loadEnv();
$cmd = sprintf(
    'mysqldump -h%s -u%s -p%s %s --single-transaction --quick --lock-tables=false > %s 2>&1',
    escapeshellarg($env['DB_HOST'] ?? 'localhost'),
    escapeshellarg($env['DB_USER'] ?? 'root'),
    escapeshellarg($env['DB_PASS'] ?? ''),
    escapeshellarg($env['DB_NAME'] ?? 'vueports_db'),
    escapeshellarg($sqlFile)
);

exec($cmd, $output, $returnCode);

if ($returnCode !== 0 || !file_exists($sqlFile) || filesize($sqlFile) === 0) {
    echo "[" . date('c') . "] ERROR: mysqldump failed\n";
    error_log("Backup failed: mysqldump error code $returnCode");
    exit(1);
}

echo "[" . date('c') . "] Database dumped: $sqlFile (" . round(filesize($sqlFile)/1024, 1) . " KB)\n";

// ── ZIP ARCHIVE (DB + uploads) ──
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    $zip->addFile($sqlFile, basename($sqlFile));
    
    // Add uploads recursively
    $uploadsDir = realpath('../uploads');
    if ($uploadsDir) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadsDir));
        foreach ($files as $file) {
            if ($file->isDir()) continue;
            $relative = 'uploads/' . substr($file->getRealPath(), strlen($uploadsDir) + 1);
            $zip->addFile($file->getRealPath(), $relative);
        }
    }
    
    $zip->close();
    echo "[" . date('c') . "] Archive created: $zipFile (" . round(filesize($zipFile)/1048576, 2) . " MB)\n";
    
    // Remove raw SQL after zipping
    unlink($sqlFile);
} else {
    echo "[" . date('c') . "] ERROR: Failed to create zip\n";
    exit(1);
}

// ── ROTATE OLD BACKUPS (keep 14 days) ──
$cutoff = strtotime('-14 days');
foreach (glob("$backupDir/vueports_backup_*.zip") as $file) {
    if (filemtime($file) < $cutoff) {
        unlink($file);
        echo "[" . date('c') . "] Deleted old backup: " . basename($file) . "\n";
    }
}

// ── OPTIONAL: S3 UPLOAD ──
$s3Bucket = $env['BACKUP_S3_BUCKET'] ?? '';
if ($s3Bucket && !empty($env['AWS_ACCESS_KEY'])) {
    $s3Key = 'backups/' . basename($zipFile);
    $s3Region = $env['BACKUP_S3_REGION'] ?? 'af-south-1';
    
    $dateStr = gmdate('Ymd\THis\Z');
    $scope = date('Ymd') . "/$s3Region/s3/aws4_request";
    // S3 upload via AWS SDK would go here; placeholder for now
    echo "[" . date('c') . "] S3 upload configured but requires AWS SDK\n";
}

echo "[" . date('c') . "] Backup completed successfully.\n";