<?php
declare(strict_types=1);

/**
 * PHPMailer Configuration
 * 
 * Setup:
 * 1. composer require phpmailer/phpmailer
 * 2. Update settings in database or hardcode below
 */

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
        return null; // Falls back to PHP mail()
    }

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = getSetting('smtp_host', 'smtp.gmail.com');
    $mail->SMTPAuth   = true;
    $mail->Username   = getSetting('smtp_user', 'njabulod.hlongwane@gmail.com');
    $mail->Password   = getSetting('smtp_pass', 'NJ@b_loHlon1802');
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int) getSetting('smtp_port', '587');
    $mail->setFrom(getSetting('smtp_from', 'noreply@vueports.co.za'), 'Vueports Solutions');
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    return $mail;
}