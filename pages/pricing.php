<?php
$basePath = '../';
$pageTitle = 'Pricing';
include '../includes/header.php';
?>

<section class="page-header">
  <div class="page-header-bg">Pricing</div>
  <div class="container">
    <div class="page-header-content">
      <span class="section-label">Pricing</span>
      <h1 class="page-header-title">Simple, transparent<br>pricing.</h1>
      <p class="page-header-desc">No hidden fees. No surprises. Choose the plan that fits your needs or build a custom package.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;">
  <div class="container">
    <div class="pricing-grid">
      <div class="pricing-card reveal">
        <h3 class="pricing-name">Starter</h3>
        <p class="pricing-desc">Perfect for small projects and MVPs.</p>
        <div class="pricing-price">$2,500<span>/project</span></div>
        <p class="pricing-period">One-time payment</p>
        <div class="pricing-features">
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Single-page application</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Up to 5 screens</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Basic API integration</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 30 days support</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Source code included</div>
        </div>
        <a href="./consultation.php" class="btn btn-secondary" style="width: 100%;">Get Started</a>
      </div>

      <div class="pricing-card featured reveal">
        <h3 class="pricing-name">Professional</h3>
        <p class="pricing-desc">For growing businesses that need more.</p>
        <div class="pricing-price">$7,500<span>/project</span></div>
        <p class="pricing-period">One-time payment</p>
        <div class="pricing-features">
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Full-stack application</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Up to 20 screens</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Advanced integrations</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 90 days support</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Database design</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Admin dashboard</div>
        </div>
        <a href="./consultation.php" class="btn btn-primary" style="width: 100%;">Get Started</a>
      </div>

      <div class="pricing-card reveal">
        <h3 class="pricing-name">Enterprise</h3>
        <p class="pricing-desc">Custom solutions for large organizations.</p>
        <div class="pricing-price">Custom<span></span></div>
        <p class="pricing-period">Contact us for a quote</p>
        <div class="pricing-features">
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Unlimited features</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Dedicated team</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> SLA & 24/7 support</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Custom AI agents</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Data engineering</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> White-label options</div>
        </div>
        <a href="./consultation.php" class="btn btn-secondary" style="width: 100%;">Contact Sales</a>
      </div>
    </div>

    <div class="text-center" style="margin-top: var(--space-12);">
      <p style="font-size: var(--text-base); color: var(--text-secondary); margin-bottom: var(--space-4);">Not sure which plan is right for you?</p>
      <a href="./calculator.php" class="btn btn-accent btn-lg">
        Try Price Calculator
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section" style="background: var(--bg-surface);">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">FAQ</span>
      <h2 class="section-title">Questions? We've got<br>answers.</h2>
    </div>

    <div class="faq-list reveal">
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          How long does a typical project take?
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Most MVP projects take 4–8 weeks. Larger enterprise solutions typically range from 3–6 months. We provide detailed timelines during our discovery phase.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          What technologies do you use?
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>We use modern, proven stacks: React/Vue/Next.js for frontend, Node.js/Python/Laravel for backend, PostgreSQL/MongoDB for data, and AWS/Azure/GCP for cloud.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          Do you offer ongoing maintenance?
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Yes! We offer flexible maintenance plans starting from $500/month. All plans include monitoring, security updates, bug fixes, and priority support.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          Can I see examples of your work?
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Absolutely. During our consultation, we'll share relevant case studies and portfolio pieces that match your industry and project type.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          What is your payment structure?
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>We typically work with a 40% deposit upfront, 30% at midpoint, and 30% on delivery. For retainer clients, we offer monthly billing with net-15 terms.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
