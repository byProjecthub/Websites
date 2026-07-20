<?php
declare(strict_types=1);
// cron/subscription-renewal.php — Recurring Billing & Subscription Manager

require_once '../includes/functions.php';
require_once '../includes/emails.php';

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

$db = db();
if (!$db) exit('Database connection failed');

// Ensure subscriptions table exists
$db->exec("CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    plan_name VARCHAR(100) NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    billing_cycle ENUM('monthly','quarterly','yearly') DEFAULT 'monthly',
    status ENUM('active','paused','cancelled','expired') DEFAULT 'active',
    start_date DATE NOT NULL,
    next_billing_date DATE NOT NULL,
    last_billed_date DATE NULL,
    end_date DATE NULL,
    payment_method VARCHAR(50),
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    INDEX idx_next_bill (next_billing_date, status),
    INDEX idx_client (client_id)
) ENGINE=InnoDB");

echo "[" . date('c') . "] Starting subscription renewal check...\n";

// ── FIND DUE SUBSCRIPTIONS ──
$stmt = $db->prepare("SELECT s.*, c.full_name, c.email 
                       FROM subscriptions s 
                       JOIN clients c ON s.client_id = c.id 
                       WHERE s.status = 'active' 
                       AND s.next_billing_date <= CURDATE() + INTERVAL 3 DAY
                       ORDER BY s.next_billing_date ASC");
$stmt->execute();
$subscriptions = $stmt->fetchAll();

$renewed = 0;
$reminded = 0;

foreach ($subscriptions as $sub) {
    $daysUntil = (int) ((strtotime($sub['next_billing_date']) - time()) / 86400);
    
    // ── RENEWAL DUE NOW OR OVERDUE ──
    if ($daysUntil <= 0) {
        // Generate invoice
        $invNum = 'SUB-' . date('Ym') . '-' . str_pad((string) $sub['id'], 4, '0', STR_PAD_LEFT);
        $db->prepare("INSERT INTO invoices (client_id, invoice_number, amount, status, due_date, notes, created_at) 
                      VALUES (?, ?, ?, 'sent', DATE_ADD(CURDATE(), INTERVAL 7 DAY), ?, NOW())")
           ->execute([
               $sub['client_id'],
               $invNum,
               $sub['amount'],
               "Subscription renewal: {$sub['plan_name']} (" . ucfirst($sub['billing_cycle']) . ")"
           ]);
        
        $invoiceId = (int) $db->lastInsertId();
        
        // Update subscription
        $nextBill = match($sub['billing_cycle']) {
            'monthly' => date('Y-m-d', strtotime('+1 month', strtotime($sub['next_billing_date']))),
            'quarterly' => date('Y-m-d', strtotime('+3 months', strtotime($sub['next_billing_date']))),
            'yearly' => date('Y-m-d', strtotime('+1 year', strtotime($sub['next_billing_date']))),
            default => date('Y-m-d', strtotime('+1 month')),
        };
        
        $db->prepare("UPDATE subscriptions SET last_billed_date = CURDATE(), next_billing_date = ?, updated_at = NOW() WHERE id = ?")
           ->execute([$nextBill, $sub['id']]);
        
        // Queue renewal email
        $db->prepare("INSERT INTO email_queue (to_email, to_name, subject, body_html, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())")
           ->execute([
               $sub['email'],
               $sub['full_name'],
               "Your {$sub['plan_name']} subscription has been renewed",
               "<p>Hi " . htmlspecialchars($sub['full_name']) . ",</p>
                <p>Your <strong>" . htmlspecialchars($sub['plan_name']) . "</strong> subscription has been renewed.</p>
                <p>Invoice: <strong>$invNum</strong><br>Amount: <strong>R" . number_format((float)$sub['amount'], 2) . "</strong><br>Next billing: <strong>" . date('F j, Y', strtotime($nextBill)) . "</strong></p>
                <p><a href='https://vueports.co.za/client/invoices.php'>View invoice & pay</a></p>"
           ]);
        
        $renewed++;
        echo "[" . date('c') . "] Renewed subscription #{$sub['id']} — Invoice $invNum generated\n";
    }
    // ── REMINDER: 3 DAYS BEFORE ──
    elseif ($daysUntil === 3) {
        $db->prepare("INSERT INTO email_queue (to_email, to_name, subject, body_html, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())")
           ->execute([
               $sub['email'],
               $sub['full_name'],
               "Upcoming renewal: {$sub['plan_name']}",
               "<p>Hi " . htmlspecialchars($sub['full_name']) . ",</p>
                <p>Your <strong>" . htmlspecialchars($sub['plan_name']) . "</strong> subscription will renew on <strong>" . date('F j, Y', strtotime($sub['next_billing_date'])) . "</strong>.</p>
                <p>Amount: R" . number_format((float)$sub['amount'], 2) . "</p>"
           ]);
        
        $reminded++;
        echo "[" . date('c') . "] Sent reminder for subscription #{$sub['id']}\n";
    }
}

// ── EXPIRE ENDED SUBSCRIPTIONS ──
$expired = $db->exec("UPDATE subscriptions SET status = 'expired', updated_at = NOW() WHERE status = 'active' AND end_date IS NOT NULL AND end_date < CURDATE()");
if ($expired > 0) {
    echo "[" . date('c') . "] Expired $expired subscriptions\n";
}

echo "[" . date('c') . "] Complete. Renewed: $renewed, Reminders: $reminded\n";