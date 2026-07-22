<?php
declare(strict_types=1);

// config/database.php - Railway production ready

$host = $_ENV['MYSQLHOST'] ?? $_ENV['DB_HOST'] ?? 'localhost';
$port = $_ENV['MYSQLPORT'] ?? $_ENV['DB_PORT'] ?? '3306';
$dbname = $_ENV['MYSQLDATABASE'] ?? $_ENV['DB_NAME'] ?? 'railway';
$username = $_ENV['MYSQLUSER'] ?? $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? $_ENV['DB_PASS'] ?? '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Only add MYSQL_ATTR_INIT_COMMAND if the constant exists
if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
    $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES $charset COLLATE utf8mb4_unicode_ci";
}

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Fallback charset setting if constant wasn't available
    if (!defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
        $pdo->exec("SET NAMES $charset COLLATE utf8mb4_unicode_ci");
    }
    
    $pdo->exec("SET time_zone = '+00:00'");
    
} catch (\PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    $pdo = null;
    
    // Always show error during setup
    die("Database connection failed: " . $e->getMessage());
}
