<?php
declare(strict_types=1);

// config/database.php — Railway deployment ready

$host = $_ENV['MYSQLHOST'] ?? $_ENV['DB_HOST'] ?? 'localhost';
$port = $_ENV['MYSQLPORT'] ?? $_ENV['DB_PORT'] ?? '3306';
$dbname = $_ENV['MYSQLDATABASE'] ?? $_ENV['DB_NAME'] ?? 'vueports_database';
$username = $_ENV['MYSQLUSER'] ?? $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT         => true,
];

if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
    $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES $charset COLLATE utf8mb4_unicode_ci";
}

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    
    if (!defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
        $pdo->exec("SET NAMES $charset COLLATE utf8mb4_unicode_ci");
    }
    
    $pdo->exec("SET time_zone = '+00:00'");
    $pdo->exec("SET SESSION sql_mode = 'STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
    
} catch (\PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    $pdo = null;
    die("Database connection failed: " . $e->getMessage());
}
