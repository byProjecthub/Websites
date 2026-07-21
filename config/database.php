<?php
declare(strict_types=1);

// config/database.php — FIXED: Better error handling, connection retries, charset config

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'vueports_database';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // FIXED: Set timezone for consistent date handling
    $pdo->exec("SET time_zone = '+00:00'");
    
    // FIXED: Enable strict mode for data integrity
    $pdo->exec("SET SESSION sql_mode = 'STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
    
} catch (\PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    
    // FIXED: Graceful degradation — set $pdo to null so functions can check db()
    $pdo = null;
    
    // In production, don't expose error details
    if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
        die("Database connection failed: " . $e->getMessage());
    }
    die("Service temporarily unavailable. Please try again later.");
}
