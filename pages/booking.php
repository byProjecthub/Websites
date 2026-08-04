<?php
$basePath = '../';
$pageTitle = 'Book a Meeting';
include '../includes/header.php';
?>

<section class="page-header">
  <div class="page-header-bg">Book</div>
  <div class="container">
    <div class="page-header-content">
      <span class="section-label">Book a Meeting</span>
      <h1 class="page-header-title">Pick a time that<br>works for you.</h1>
      <p class="page-header-desc">Select a date and time slot below. We'll send a calendar invite with a video link.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;">
  <div class="container">
    <div class="booking-grid">
      <div class="booking-sidebar reveal">
        <div class="booking-step-indicator">
          <div class="booking-step active">
            <div class="step-number">1</div>
            <div class="step-label">Date</div>
          </div>
          <div class="booking-step-line"></div>
          <div class="booking-step">
            <div class="step-number">2</div>
            <div class="step-label">Time</div>
          </div>
          <div class="booking-step-line"></div>
          <div class="booking-step">
            <div class="step-number">3</div>
            <div class="step-label">Details</div>
          </div>
        </div>

        <div style="padding: var(--space-8); background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-xl);">
          <h3 style="font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-4);">Meeting Details</h3>
          <div style="display: flex; flex-direction: column; gap: var(--space-4);">
            <div style="display: flex; align-items: center; gap: var(--space-3);">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-indigo)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              <span style="font-size: var(--text-sm); color: var(--text-secondary);">30 minutes</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-3);">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-indigo)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              <span style="font-size: var(--text-sm); color: var(--text-secondary);">Google Meet (video)</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-3);">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-indigo)" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              <span style="font-size: var(--text-sm); color: var(--text-secondary);">EAT (Nairobi time)</span>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-xl); padding: var(--space-10); margin-bottom: var(--space-8);">
          <h3 style="font-size: var(--text-xl); font-weight: 700; margin-bottom: var(--space-6);">Select a Date</h3>
          <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: var(--space-2); margin-bottom: var(--space-4);">
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Mon</div>
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Tue</div>
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Wed</div>
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Thu</div>
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Fri</div>
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Sat</div>
            <div style="text-align: center; font-size: var(--text-xs); color: var(--text-muted); padding: var(--space-2);">Sun</div>
          </div>
          <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: var(--space-2);">
            <!-- Sample calendar days -->
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">28</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">29</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">30</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--border-subtle); cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.borderColor='var(--accent-indigo)'" onmouseout="this.style.borderColor='var(--border-subtle)'">31</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--accent-indigo); background: var(--accent-indigo-bg); cursor: pointer;">1</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">2</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">3</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--border-subtle); cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.borderColor='var(--accent-indigo)'" onmouseout="this.style.borderColor='var(--border-subtle)'">4</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--border-subtle); cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.borderColor='var(--accent-indigo)'" onmouseout="this.style.borderColor='var(--border-subtle)'">5</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--border-subtle); cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.borderColor='var(--accent-indigo)'" onmouseout="this.style.borderColor='var(--border-subtle)'">6</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--border-subtle); cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.borderColor='var(--accent-indigo)'" onmouseout="this.style.borderColor='var(--border-subtle)'">7</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-primary); border: 1.5px solid var(--border-subtle); cursor: pointer; transition: all var(--transition-fast);" onmouseover="this.style.borderColor='var(--accent-indigo)'" onmouseout="this.style.borderColor='var(--border-subtle)'">8</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">9</div>
            <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-lg); font-size: var(--text-sm); color: var(--text-muted); cursor: not-allowed;">10</div>
          </div>
        </div>

        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-xl); padding: var(--space-10);">
          <h3 style="font-size: var(--text-xl); font-weight: 700; margin-bottom: var(--space-6);">Available Times — Friday, Aug 1</h3>
          <div class="time-slot-grid">
            <div class="time-slot">9:00 AM</div>
            <div class="time-slot">9:30 AM</div>
            <div class="time-slot selected">10:00 AM</div>
            <div class="time-slot">10:30 AM</div>
            <div class="time-slot">11:00 AM</div>
            <div class="time-slot unavailable">11:30 AM</div>
            <div class="time-slot">2:00 PM</div>
            <div class="time-slot">2:30 PM</div>
            <div class="time-slot">3:00 PM</div>
            <div class="time-slot">3:30 PM</div>
            <div class="time-slot unavailable">4:00 PM</div>
            <div class="time-slot">4:30 PM</div>
          </div>

          <div style="margin-top: var(--space-8);">
            <button class="btn btn-primary btn-lg" style="width: 100%;">
              Confirm Booking
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
