<?php
declare(strict_types=1);

// import-db.php - Auto-import database on Railway deploy
// Uses Railway's native MySQL environment variables

$host = $_ENV['MYSQLHOST'] ?? 'mysql.railway.internal';
$port = $_ENV['MYSQLPORT'] ?? '3306';
$dbname = $_ENV['MYSQLDATABASE'] ?? 'railway';
$username = $_ENV['MYSQLUSER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? '';
$charset = 'utf8mb4';

// Also support DB_* aliases for flexibility
$host = $_ENV['DB_HOST'] ?? $host;
$port = $_ENV['DB_PORT'] ?? $port;
$dbname = $_ENV['DB_NAME'] ?? $dbname;
$username = $_ENV['DB_USER'] ?? $username;
$password = $_ENV['DB_PASS'] ?? $password;

$dsn = "mysql:host=$host;port=$port;charset=$charset";

echo "Connecting to MySQL at $host:$port...\n";

try {
    // Connect without specifying database first
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbname' ready.\n";
    
    // Switch to the database
    $pdo->exec("USE `$dbname`");
    
    // Check if tables already exist
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) === 0) {
        echo "Database is empty. Looking for SQL import file...\n";
        
        // Try multiple possible SQL file names
        $possibleFiles = [
            __DIR__ . '/database.sql',
            __DIR__ . '/database - Copy.sql',
            __DIR__ . '/database.sql',
            __DIR__ . '/vueports_database.sql',
            __DIR__ . '/dump.sql',
        ];
        
        $sqlFile = null;
        foreach ($possibleFiles as $file) {
            if (file_exists($file)) {
                $sqlFile = $file;
                break;
            }
        }
        
        if ($sqlFile) {
            echo "Found: $sqlFile\n";
            $sql = file_get_contents($sqlFile);
            
            // Split and execute statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            $success = 0;
            $failed = 0;
            
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    try {
                        $pdo->exec($statement);
                        $success++;
                    } catch (PDOException $e) {
                        // Ignore "already exists" errors, log others
                        if (strpos($e->getMessage(), 'already exists') === false) {
                            echo "Warning: " . $e->getMessage() . "\n";
                            $failed++;
                        } else {
                            $success++;
                        }
                    }
                }
            }
            
            echo "Import complete: $success statements executed, $failed warnings.\n";
        } else {
            echo "No SQL file found. Checked: " . implode(', ', $possibleFiles) . "\n";
        }
    } else {
        echo "Database already has " . count($tables) . " tables. Skipping import.\n";
    }
    
    // Verify connection to actual database works
    $pdo->exec("USE `$dbname`");
    $count = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Connected to '$dbname' with " . count($count) . " tables.\n";
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "DSN: $dsn\n";
    echo "User: $username\n
