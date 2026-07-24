<?php
declare(strict_types=1);
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/emails.php';
require_once 'includes/security.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh and try again.';
    } elseif (!checkRateLimit($_SERVER['REMOTE_ADDR'] . ':contact', 5, 1)) {
        $error = 'Too many attempts. Please wait a minute.';
    } else {
        $name    = sanitize($_POST['name'] ?? '');
        $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone   = sanitize($_POST['phone'] ?? '');
        $subject = sanitize($_POST['subject'] ?? '');
        $message = sanitize($_POST['message'] ?? '');
        $service = sanitize($_POST['service_interest'] ?? '');

        if (empty($name) || empty($email) || empty($message)) {
            $error = 'Please fill in all required fields.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $db = db();
            
            // Check database connection
            if (!$db) {
                $error = 'Database connection failed. Please try again later.';
                error_log('CONTACT FORM ERROR: db() returned null');
            } else {
                try {
                    // Insert into messages table
                    $stmt = $db->prepare("INSERT INTO messages (name, email, phone, subject, message, service_interest, status, created_at) VALUES (?,?,?,?,?,?, 'new', NOW())");
                    $stmt->execute([$name, $email, $phone, $subject, $message, $service]);
                    $messageId = (int) $db->lastInsertId();
                    
                    if ($messageId === 0) {
                        throw new Exception('Insert succeeded but no ID returned');
                    }
                    
                    error_log("CONTACT FORM: Saved message ID $messageId from $email");
                    
                    // Send emails (non-blocking: don't fail form if email fails)
                    $leadData = [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'subject' => $subject,
                        'message' => $message,
                        'service_interest' => $service
                    ];
                    
                    $confirmOk = sendContactConfirmation($leadData);
                    $adminOk   = sendAdminLeadNotification($leadData);
                    
                    if (!$confirmOk) {
                        error_log("CONTACT FORM: sendContactConfirmation failed for $email");
                    }
                    if (!$adminOk) {
                        error_log("CONTACT FORM: sendAdminLeadNotification failed for $email");
                    }
                    
                    $success = 'Thank you! Your message has been received. We will respond within 24 hours.';
                    
                } catch (PDOException $e) {
                    error_log('CONTACT FORM DB ERROR: ' . $e->getMessage());
                    $error = 'Unable to save your message. Please try again later.';
                } catch (Exception $e) {
                    error_log('CONTACT FORM ERROR: ' . $e->getMessage());
                    $error = 'Something went wrong. Please try again.';
                }
            }
        }
    }
}

$pageTitle = 'Contact';
require_once 'includes/header.php';
?>
