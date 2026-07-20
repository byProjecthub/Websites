<?php
declare(strict_types=1);
// cron/process-emails.php — Email Queue Processor

require_once '../includes/functions.php';
require_once '../includes/mailer.php';

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

$db = db();
if (!$db) exit('Database connection failed');

// Ensure email_queue table exists (idempotent)
$db->exec("CREATE TABLE IF NOT EXISTS email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    to_email VARCHAR(255) NOT NULL,
    to_name VARCHAR(255),
    subject VARCHAR(255) NOT NULL,
    body_html TEXT,
    body_text TEXT,
    status ENUM('pending','sent','failed') DEFAULT 'pending',
    attempts TINYINT DEFAULT 0,
    error_message TEXT,
    created_at DATETIME DEFAULT NOW(),
    sent_at DATETIME NULL,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB");

$maxAttempts = 3;
$batchSize = 20;

echo "[" . date('c') . "] Starting email queue processor...\n";

// Fetch pending emails
$stmt = $db->prepare("SELECT * FROM email_queue WHERE status = 'pending' AND attempts < ? ORDER BY created_at ASC LIMIT ?");
$stmt->execute([$maxAttempts, $batchSize]);
$emails = $stmt->fetchAll();

if (empty($emails)) {
    echo "[" . date('c') . "] No pending emails.\n";
    exit(0);
}

$sent = 0;
$failed = 0;

foreach ($emails as $email) {
    $id = (int) $email['id'];
    
    try {
        $mail = getMailer();
        $mail->addAddress($email['to_email'], $email['to_name'] ?? '');
        $mail->Subject = $email['subject'];
        
        if ($email['body_html']) {
            $mail->isHTML(true);
            $mail->Body = $email['body_html'];
            $mail->AltBody = $email['body_text'] ?? strip_tags($email['body_html']);
        } else {
            $mail->Body = $email['body_text'] ?? '';
        }
        
        $mail->send();
        
        $db->prepare("UPDATE email_queue SET status = 'sent', sent_at = NOW(), attempts = attempts + 1 WHERE id = ?")
           ->execute([$id]);
        
        // Log to email_logs
        $db->prepare("INSERT INTO email_logs (recipient, subject, status, sent_at, created_at) VALUES (?, ?, 'delivered', NOW(), NOW())")
           ->execute([$email['to_email'], $email['subject']]);
        
        $sent++;
        echo "[" . date('c') . "] Sent email #$id to {$email['to_email']}\n";
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        $db->prepare("UPDATE email_queue SET attempts = attempts + 1, error_message = ?, status = IF(attempts + 1 >= ?, 'failed', 'pending') WHERE id = ?")
           ->execute([$error, $maxAttempts, $id]);
        
        // Log failure
        $db->prepare("INSERT INTO email_logs (recipient, subject, status, error, created_at) VALUES (?, ?, 'failed', ?, NOW())")
           ->execute([$email['to_email'], $email['subject'], $error]);
        
        $failed++;
        echo "[" . date('c') . "] FAILED email #$id: $error\n";
    }
    
    // Rate limit: brief pause between sends
    usleep(200000); // 200ms
}

echo "[" . date('c') . "] Batch complete. Sent: $sent, Failed: $failed\n";

// ── RETRY OLD FAILED (optional, after cooldown) ──
$retryStmt = $db->prepare("UPDATE email_queue SET status = 'pending', attempts = 0 WHERE status = 'failed' AND attempts >= ? AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
$retryStmt->execute([$maxAttempts]);
if ($retryStmt->rowCount() > 0) {
    echo "[" . date('c') . "] Reset {$retryStmt->rowCount()} failed emails for retry.\n";
}