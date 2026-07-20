<?php
// includes/google-calendar.php
use Google\Client;
use Google\Service\Calendar;

function createCalendarEvent(array $booking): string {
    $client = new Client();
    $client->setAuthConfig(__DIR__ . '/../config/google-credentials.json');
    $client->addScope(Calendar::CALENDAR);
    
    $service = new Calendar($client);
    
    $event = new Calendar\Event([
        'summary' => 'Vueports Consultation: ' . $booking['name'],
        'description' => 'Service: ' . ($booking['service_type'] ?: 'General') . "\nNotes: " . ($booking['notes'] ?: 'None'),
        'start' => [
            'dateTime' => $booking['booking_date'] . 'T' . $booking['booking_time'],
            'timeZone' => $booking['timezone']
        ],
        'end' => [
            'dateTime' => $booking['booking_date'] . 'T' . date('H:i:s', strtotime($booking['booking_time'] . ' +1 hour')),
            'timeZone' => $booking['timezone']
        ],
        'attendees' => [
            ['email' => $booking['email']],
            ['email' => getenv('CONSULTATION_EMAIL')]
        ],
        'conferenceData' => [
            'createRequest' => [
                'requestId' => 'vueports-' . $booking['id'],
                'conferenceSolutionKey' => ['type' => 'hangoutsMeet']
            ]
        ]
    ]);
    
    $event = $service->events->insert('primary', $event, ['conferenceDataVersion' => 1]);
    return $event->getHangoutLink(); // Returns Meet URL
}