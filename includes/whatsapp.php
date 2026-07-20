<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/env.php';

function sendWhatsApp(string $to, string $template, array $params = []): bool {
    $token = env('WHATSAPP_API_TOKEN', '');
    $phoneId = env('WHATSAPP_PHONE_ID', '');
    
    if (!$token || !$phoneId) {
        error_log('WhatsApp not configured');
        return false;
    }
    
    $url = "https://graph.facebook.com/v18.0/{$phoneId}/messages";
    
    $components = [];
    foreach ($params as $param) {
        $components[] = [
            'type' => 'body',
            'parameters' => [['type' => 'text', 'text' => $param]]
        ];
    }
    
    $data = [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => preg_replace('/[^0-9]/', '', $to),
        'type' => 'template',
        'template' => [
            'name' => $template,
            'language' => ['code' => 'en'],
            'components' => $components
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer {$token}",
            "Content-Type: application/json"
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        error_log("WhatsApp API error: HTTP {$httpCode} - {$response}");
        return false;
    }
    
    return true;
}

function sendWhatsAppBookingReminder(array $booking): bool {
    return sendWhatsApp(
        $booking['phone'],
        'booking_reminder',
        [
            $booking['name'],
            date('j F Y', strtotime($booking['booking_date'])),
            date('g:i A', strtotime($booking['booking_time']))
        ]
    );
}