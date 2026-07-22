<?php
declare(strict_types=1);

$host = $_ENV['MYSQLHOST'] ?? 'mysql.railway.internal';
$port = $_ENV['MYSQLPORT'] ?? '3306';
$dbname = $_ENV['MYSQLDATABASE'] ?? 'railway';
$username = $_ENV['MYSQLUSER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;charset=$charset";

echo "Connecting to MySQL at $host:$port...\n";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbname' ready.\n";
    
    $pdo->exec("USE `$dbname`");
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) === 0) {
        echo "Database empty. Importing...\n";
        $files = ['/var/www/html/database.sql', '/var/www/html/database - Copy.sql'];
        $sqlFile = null;
        foreach ($files as $f) {
            if (file_exists($f)) {
                $sqlFile = $f;
                break;
            }
        }
        
        if ($sqlFile) {
            $sql = file_get_contents($sqlFile);
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $stmt) {
                if (!empty($stmt)) {
                    try {
                        $pdo->exec($stmt);
                    } catch (PDOException $e) {
                        // ignore errors
                    }
                }
            }
            echo "Import done.\n";
        }
    } else {
        echo "Database has " . count($tables) . " tables. Skipping import.\n";
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
