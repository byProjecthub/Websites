<?php
$pageTitle = 'Price Calculator';
include '../includes/header.php';
?>

<section class="page-header">
  <div class="page-header-bg">Calculate</div>
  <div class="container">
    <div class="page-header-content">
      <span class="section-label">Price Calculator</span>
      <h1 class="page-header-title">Estimate your<br>project cost.</h1>
      <p class="page-header-desc">Answer a few questions and get an instant ballpark estimate for your project.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;">
  <div class="container">
    <div class="calculator-card reveal">
      <!-- Project Type -->
      <div class="calculator-section">
        <h3>What type of project do you need?</h3>
        <div class="calculator-options">
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Web Application</span>
            </div>
            <span class="option-price">From $5,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Mobile Application</span>
            </div>
            <span class="option-price">From $8,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Data Engineering</span>
            </div>
            <span class="option-price">From $6,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">AI / Automation</span>
            </div>
            <span class="option-price">From $10,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">MVP / Prototype</span>
            </div>
            <span class="option-price">From $2,500</span>
          </label>
        </div>
      </div>

      <!-- Complexity -->
      <div class="calculator-section">
        <h3>What's the complexity level?</h3>
        <div class="calculator-options">
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Simple — Basic features, minimal integrations</span>
            </div>
            <span class="option-price">Base</span>
          </label>
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Medium — Multiple features, some integrations</span>
            </div>
            <span class="option-price">+40%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Complex — Advanced features, many integrations</span>
            </div>
            <span class="option-price">+80%</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Enterprise — Custom everything, high scale</span>
            </div>
            <span class="option-price">Custom</span>
          </label>
        </div>
      </div>

      <!-- Add-ons -->
      <div class="calculator-section">
        <h3>Any add-ons?</h3>
        <div class="calculator-options">
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Admin Dashboard</span>
            </div>
            <span class="option-price">+$1,500</span>
          </label>
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Payment Integration</span>
            </div>
            <span class="option-price">+$1,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">Real-time Chat / Notifications</span>
            </div>
            <span class="option-price">+$2,000</span>
          </label>
          <label class="calculator-option">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">AI Features (Chatbot, Recommendations)</span>
            </div>
            <span class="option-price">+$3,500</span>
          </label>
          <label class="calculator-option selected">
            <div class="option-info">
              <div class="option-radio"><div></div></div>
              <span class="option-name">3 Months Support</span>
            </div>
            <span class="option-price">+$1,500</span>
          </label>
        </div>
      </div>

      <!-- Total -->
      <div class="calculator-total">
        <div class="total-label">Estimated Total</div>
        <div class="total-value">$12,500</div>
      </div>

      <div style="display: flex; gap: var(--space-4); margin-top: var(--space-8); flex-wrap: wrap;">
        <a href="../consultation.php" class="btn btn-primary btn-lg" style="flex: 1; min-width: 200px;">
          Book a Free Call
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
        <a href="../contact.php" class="btn btn-secondary btn-lg" style="flex: 1; min-width: 200px;">Send Inquiry</a>
      </div>

      <p style="font-size: var(--text-xs); color: var(--text-muted); text-align: center; margin-top: var(--space-6);">This is a ballpark estimate. Final pricing depends on detailed requirements. Book a call for an accurate quote.</p>
    </div>
  </div>
</section>

<script>
document.querySelectorAll('.calculator-option').forEach(option => {
  option.addEventListener('click', function() {
    // For radio-style groups (first two sections)
    const parent = this.closest('.calculator-section');
    const isMulti = parent.querySelectorAll('.calculator-option').length > 4;

    if (!isMulti) {
      parent.querySelectorAll('.calculator-option').forEach(o => o.classList.remove('selected'));
    }
    this.classList.toggle('selected');
  });
});
</script>

<?php include '../includes/footer.php'; ?>
