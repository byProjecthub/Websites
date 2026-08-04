<?php
$basePath = '../';
$pageTitle = 'Free Consultation';
include '../includes/header.php';
?>

<section class="page-header">
  <div class="page-header-bg">Consult</div>
  <div class="container">
    <div class="page-header-content">
      <span class="section-label">Free Consultation</span>
      <h1 class="page-header-title">Let's discuss your<br>next project.</h1>
      <p class="page-header-desc">Book a free 30-minute call. No commitment, no pressure — just honest advice about your technology needs.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;">
  <div class="container">
    <div class="contact-grid">
      <div class="reveal">
        <span class="section-label">What to Expect</span>
        <h2 class="section-title" style="margin-bottom: var(--space-8);">Here's how it works.</h2>

        <div style="display: flex; flex-direction: column; gap: var(--space-8);">
          <div style="display: flex; gap: var(--space-4);">
            <div style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--accent-indigo); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--text-primary); flex-shrink: 0;">1</div>
            <div>
              <h4 style="font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-2);">Book Your Slot</h4>
              <p style="font-size: var(--text-base); color: var(--text-secondary); line-height: 1.6;">Pick a time that works for you from our calendar. We'll send a confirmation with a video call link.</p>
            </div>
          </div>
          <div style="display: flex; gap: var(--space-4);">
            <div style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--accent-cyan); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--text-primary); flex-shrink: 0;">2</div>
            <div>
              <h4 style="font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-2);">Discovery Call</h4>
              <p style="font-size: var(--text-base); color: var(--text-secondary); line-height: 1.6;">We'll discuss your goals, challenges, and budget. We'll ask questions and share initial thoughts.</p>
            </div>
          </div>
          <div style="display: flex; gap: var(--space-4);">
            <div style="width: 48px; height: 48px; border-radius: var(--radius-full); background: var(--accent-pink); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--text-primary); flex-shrink: 0;">3</div>
            <div>
              <h4 style="font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-2);">Proposal</h4>
              <p style="font-size: var(--text-base); color: var(--text-secondary); line-height: 1.6;">Within 48 hours, you'll receive a detailed proposal with scope, timeline, and pricing.</p>
            </div>
          </div>
        </div>

        <div style="margin-top: var(--space-12); padding: var(--space-8); background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-xl);">
          <h3 style="font-size: var(--text-lg); font-weight: 600; margin-bottom: var(--space-4);">Not ready for a call?</h3>
          <p style="font-size: var(--text-sm); color: var(--text-secondary); margin-bottom: var(--space-6);">Use our price calculator to get an instant estimate for your project.</p>
          <a href="./calculator.php" class="btn btn-secondary">
            Price Calculator
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>

      <div class="contact-form-card reveal">
        <h3 style="font-size: var(--text-2xl); font-weight: 700; margin-bottom: var(--space-2);">Book your free call</h3>
        <p style="font-size: var(--text-sm); color: var(--text-muted); margin-bottom: var(--space-8);">Fill out the form and we'll find a time that works.</p>

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
            <label class="form-label">Project Type</label>
            <select class="form-select">
              <option value="">Select project type</option>
              <option value="mvp">MVP Development</option>
              <option value="webapp">Web Application</option>
              <option value="mobile">Mobile App</option>
              <option value="data">Data Engineering</option>
              <option value="ai">AI / Automation</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Tell us about your project</label>
            <textarea class="form-textarea" placeholder="What are you trying to build? What's your timeline?" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
            Request Consultation
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
