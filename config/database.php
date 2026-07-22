<?php
declare(strict_types=1);

$host = $_ENV['MYSQLHOST'] ?? 'mysql.railway.internal';
$port = $_ENV['MYSQLPORT'] ?? '3306';
$dbname = $_ENV['MYSQLDATABASE'] ?? 'railway';
$username = $_ENV['MYSQLUSER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->exec("SET NAMES $charset COLLATE utf8mb4_unicode_ci");
} catch (\PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    die("Database connection failed: " . $e->getMessage());
}
