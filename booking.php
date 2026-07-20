<?php
declare(strict_types=1);
require_once 'includes/functions.php';
require_once 'includes/emails.php';


$success = ''; 
$error = '';

$timeSlots = ['09:00:00','10:00:00','11:00:00','13:00:00','14:00:00','15:00:00','16:00:00'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh and try again.';
    } else {
        $date  = $_POST['booking_date'] ?? '';
        $time  = $_POST['booking_time'] ?? '';
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        if (empty($date) || empty($time) || empty($_POST['name']) || empty($email)) {
            $error = 'Please fill in all required fields and select a time slot.';
        } elseif ($date < date('Y-m-d')) {
            $error = 'You cannot book a date in the past.';
        } elseif (!isSlotAvailable($date, $time)) {
            $error = 'That time slot has just been taken. Please select another.';
        } else {
            $data = [
                'name'         => sanitize($_POST['name'] ?? ''),
                'email'        => $email,
                'phone'        => sanitize($_POST['phone'] ?? ''),
                'service_type' => sanitize($_POST['service_type'] ?? ''),
                'booking_date' => $date,
                'booking_time' => $time,
                'timezone'     => sanitize($_POST['timezone'] ?? 'Africa/Johannesburg'),
                'notes'        => sanitize($_POST['notes'] ?? ''),
            ];

            $db = db();
            if ($db) {
                $stmt = $db->prepare("INSERT INTO bookings (name, email, phone, service_type, booking_date, booking_time, timezone, notes) VALUES (?,?,?,?,?,?,?,?)");
                $stmt->execute(array_values($data));
            }
            sendBookingConfirmation($data);
            sendBookingAdminAlert($data);
            $success = 'Your meeting is scheduled. A confirmation email has been sent with your date and time.';
        }
    }
}

$pageTitle = 'Book a Meeting';
require_once 'includes/header.php';
?>

<section class="services-hero" style="padding-top:140px;">
    <div class="container">
        <span class="section-tag">/ Booking</span>
        <h1>Schedule Your <span class="highlight">Discovery Call</span></h1>
        <p>Pick a date and time. We will send you a video link 2 hours before the meeting.</p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:700px;">
        <?php if ($success): ?>
            <div class="alert alert-success" style="margin-bottom:24px;">
                <i class="fas fa-check-circle"></i> <?= $success ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger" style="margin-bottom:24px;">
                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="booking.php" style="display:flex; flex-direction:column; gap:20px;" id="bookingForm">
            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">
            <input type="hidden" name="recaptcha_token" id="recaptchaToken">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" required class="form-input">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" required class="form-input">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-input">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Service</label>
                    <select name="service_type" class="form-select">
                        <option value="">General Consultation</option>
                        <option value="Custom Software & Web">Custom Software & Web</option>
                        <option value="Data Engineering">Data Engineering</option>
                        <option value="AI Agent Development">AI Agent Development</option>
                    </select>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Date *</label>
                    <input type="date" name="booking_date" id="bookingDate" required min="<?= date('Y-m-d') ?>" class="form-input">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Timezone</label>
                    <select name="timezone" class="form-select">
                        <option value="Africa/Johannesburg">Johannesburg (SAST)</option>
                        <option value="Europe/London">London (GMT/BST)</option>
                        <option value="America/New_York">New York (ET)</option>
                        <option value="Asia/Dubai">Dubai (GST)</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin:0;">
                <label class="form-label">Available Time Slots *</label>
                <div class="time-slots">
                    <?php foreach ($timeSlots as $slot): ?>
                    <label class="time-slot">
                        <input type="radio" name="booking_time" value="<?= $slot ?>" required>
                        <span><?= date('g:i A', strtotime($slot)) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group" style="margin:0;">
                <label class="form-label">Notes / Agenda</label>
                <textarea name="notes" rows="3" class="form-textarea" placeholder="What should we focus on during the call?"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="align-self:flex-start;" onclick="window.executeRecaptcha('booking')">
                <i class="fas fa-calendar-check"></i> Confirm Booking
            </button>
        </form>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>