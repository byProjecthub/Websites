<?php
declare(strict_types=1);

function getMailer() {
    $composerAutoload = __DIR__ . '/../vendor/autoload.php';
    $manualPHPMailer  = __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    
    if (file_exists($composerAutoload)) {
        require_once $composerAutoload;
    } elseif (file_exists($manualPHPMailer)) {
        require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
        require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
    } else {
        error_log('PHPMailer not found');
        return null;
    }

    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Read from Railway env vars
        $user     = $_ENV['SMTP_USER'] ?? getSetting('smtp_user', 'njabulod.hlongwane@gmail.com');
        $pass     = $_ENV['SMTP_PASS'] ?? getSetting('smtp_pass', '');
        $host     = $_ENV['SMTP_HOST'] ?? getSetting('smtp_host', 'smtp.gmail.com');
        $port     = (int) ($_ENV['SMTP_PORT'] ?? getSetting('smtp_port', '587'));
        $fromName = $_ENV['SMTP_FROM_NAME'] ?? getSetting('smtp_from_name', 'Vueports Solutions');
        
        // CRITICAL FIX: From address MUST match your authenticated Gmail
        // You cannot send from noreply@vueports.com unless you verify/own it
        $fromEmail = $_ENV['SMTP_FROM'] ?? getSetting('smtp_from', $user);
        
        if (empty($pass)) {
            error_log('SMTP_PASS not set. Add it to Railway environment variables.');
            return null;
        }

        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $user;
        $mail->Password   = $pass;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $port;
        $mail->CharSet    = 'UTF-8';
        $mail->isHTML(true);
        $mail->SMTPDebug  = (int) ($_ENV['SMTP_DEBUG'] ?? '0');
        
        // Gmail requirement: From must match authenticated user
        $mail->setFrom($fromEmail, $fromName);
        
        // Reply-To can be different (e.g., your real contact email)
        $replyTo = $_ENV['SMTP_REPLY_TO'] ?? getSetting('contact_email', $user);
        $mail->addReplyTo($replyTo, $fromName);
        
        return $mail;
        
    } catch (Exception $e) {
        error_log('PHPMailer error: ' . $e->getMessage());
        return null;
    }
}
