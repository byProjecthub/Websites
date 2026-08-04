<?php
$pageTitle = 'Contact';
include '../includes/header.php';
?>

<section class="page-header">
  <div class="page-header-bg">Contact</div>
  <div class="container">
    <div class="page-header-content">
      <span class="section-label">Contact</span>
      <h1 class="page-header-title">Let's start<br>a conversation.</h1>
      <p class="page-header-desc">Have a project in mind? We'd love to hear about it. Reach out and we'll get back to you within 24 hours.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;">
  <div class="container">
    <div class="contact-grid">
      <div class="reveal">
        <span class="section-label">Get in Touch</span>
        <h2 class="section-title" style="margin-bottom: var(--space-8);">We're here to help.</h2>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          </div>
          <div class="contact-info-text">
            <h4>Email</h4>
            <p>hello@vueports.com<br>support@vueports.com</p>
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          </div>
          <div class="contact-info-text">
            <h4>Phone</h4>
            <p>+254 700 123 456<br>Mon–Fri, 9am–6pm EAT</p>
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          </div>
          <div class="contact-info-text">
            <h4>Office</h4>
            <p>Vueports House, Kilimani<br>Nairobi, Kenya</p>
          </div>
        </div>

        <div style="margin-top: var(--space-12); padding: var(--space-8); background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-xl);">
          <h3 style="font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-4);">Prefer to book directly?</h3>
          <p style="font-size: var(--text-sm); color: var(--text-secondary); margin-bottom: var(--space-6);">Schedule a free 30-minute consultation at a time that works for you.</p>
          <a href="../booking.php" class="btn btn-primary">
            Book a Meeting
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>

      <div class="contact-form-card reveal">
        <h3 style="font-size: var(--text-2xl); font-weight: 700; margin-bottom: var(--space-2);">Send us a message</h3>
        <p style="font-size: var(--text-sm); color: var(--text-muted); margin-bottom: var(--space-8);">Fill out the form below and we'll respond within 24 hours.</p>

        <form action="" method="POST">
          <div class="grid-2" style="gap: var(--space-4);">
            <div class="form-group">
              <label class="form-label">First Name</label>
              <input type="text" class="form-input" placeholder="John" required>
            </div>
            <div class="form-group">
              <label class="form-label">Last Name</label>
              <input type="text" class="form-input" placeholder="Doe" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-input" placeholder="john@company.com" required>
          </div>

          <div class="form-group">
            <label class="form-label">Company</label>
            <input type="text" class="form-input" placeholder="Your company name">
          </div>

          <div class="form-group">
            <label class="form-label">Service Interest</label>
            <select class="form-select">
              <option value="">Select a service</option>
              <option value="software">Custom Software</option>
              <option value="data">Data Engineering</option>
              <option value="ai">AI Agents</option>
              <option value="cloud">Cloud Solutions</option>
              <option value="consulting">Consulting</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Message</label>
            <textarea class="form-textarea" placeholder="Tell us about your project..." required></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
            Send Message
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
