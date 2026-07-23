<?php
declare(strict_types=1);

require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/emails.php';
require_once 'config/phpmailer-config.php';

// Security: simple secret key via query string or env var
$secret = $_GET['key'] ?? '';
$expected = $_ENV['QUEUE_SECRET'] ?? 'vueports-queue-2024';

if ($secret !== $expected) {
    http_response_code(403);
    die('Forbidden');
}

header('Content-Type: application/json');

$result = processEmailQueue(batchSize: 20, maxAttempts: 3);
echo json_encode([
    'success' => true,
    'sent' => $result['sent'],
    'failed' => $result['failed'],
    'timestamp' => date('Y-m-d H:i:s'),
]);
