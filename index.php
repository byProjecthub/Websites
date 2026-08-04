<?php
$pageTitle = 'Home';
$basePath = './';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-label animate-fade-in-up">
        <span class="dot"></span>
        Available for new projects
      </div>
      <h1 class="hero-title animate-fade-in-up delay-100">
        The super fast<br>
        software studio<br>
        for <span class="accent">modern teams.</span>
      </h1>
      <p class="hero-subtitle animate-fade-in-up delay-200">
        We build custom software, data pipelines, and AI agents that help your business move faster, think smarter, and scale effortlessly.
      </p>
      <div class="hero-actions animate-fade-in-up delay-300">
        <a href="pages/consultation.php" class="btn btn-primary btn-lg">
          Start a Project
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
        <a href="pages/services.php" class="btn btn-secondary btn-lg">Explore Services</a>
      </div>
    </div>
  </div>
  <div class="hero-bg-text">Vueports</div>
</section>

<!-- Logo Bar -->
<section class="logo-bar section-sm">
  <div class="container">
    <p class="logo-bar-label reveal">Trusted by forward-thinking companies</p>
    <div class="logo-bar-grid reveal">
      <div class="logo-bar-item">TechCorp</div>
      <div class="logo-bar-item">DataFlow</div>
      <div class="logo-bar-item">CloudNine</div>
      <div class="logo-bar-item">Apex AI</div>
      <div class="logo-bar-item">NexGen</div>
      <div class="logo-bar-item">Streamline</div>
    </div>
  </div>
</section>

<!-- Services Section -->
<section class="section">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">What We Do</span>
      <h2 class="section-title">Everything you need to<br>build and scale.</h2>
      <p class="section-desc">From custom applications to intelligent AI agents — we handle the tech so you can focus on growth.</p>
    </div>

    <div class="services-grid">
      <div class="service-card accent-cyan reveal">
        <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="16 18 22 12 16 6"></polyline>
            <polyline points="8 6 2 12 8 18"></polyline>
          </svg>
        </div>
        <h3 class="service-title">Custom Software</h3>
        <p class="service-desc">Tailored web and mobile applications built with modern stacks. Scalable, secure, and designed around your workflow.</p>
        <a href="pages/services.php#software" class="service-link">
          Learn More
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="service-card accent-blue reveal">
        <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
          </svg>
        </div>
        <h3 class="service-title">Data Engineering</h3>
        <p class="service-desc">ETL pipelines, data warehouses, and real-time analytics. Turn raw data into actionable business intelligence.</p>
        <a href="pages/services.php#data" class="service-link">
          Learn More
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="service-card accent-violet reveal">
        <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.387-1 1.732V7h1a7 7 0 0 1 7 7v4a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-4a7 7 0 0 1 7-7h1V5.732A2.001 2.001 0 0 1 12 2z"></path>
            <path d="M9 21h6"></path>
          </svg>
        </div>
        <h3 class="service-title">AI Agents</h3>
        <p class="service-desc">Intelligent automation that handles repetitive tasks, answers queries, and makes decisions — 24/7, without breaks.</p>
        <a href="pages/services.php#ai" class="service-link">
          Learn More
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="service-card accent-pink reveal">
        <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
          </svg>
        </div>
        <h3 class="service-title">Cloud Solutions</h3>
        <p class="service-desc">AWS, Azure, and GCP architecture, migration, and DevOps. Infrastructure that scales with your ambition.</p>
        <a href="pages/services.php#cloud" class="service-link">
          Learn More
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="service-card accent-amber reveal">
        <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
          </svg>
        </div>
        <h3 class="service-title">Tech Consulting</h3>
        <p class="service-desc">Strategic guidance on architecture, tech stack selection, and digital transformation roadmaps.</p>
        <a href="pages/services.php#consulting" class="service-link">
          Learn More
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="service-card accent-emerald reveal">
        <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
        </div>
        <h3 class="service-title">Ongoing Support</h3>
        <p class="service-desc">Maintenance, monitoring, and continuous improvement. We stay with you long after launch day.</p>
        <a href="pages/services.php#support" class="service-link">
          Learn More
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="section" style="background: var(--bg-surface);">
  <div class="container">
    <div class="about-grid">
      <div class="about-visual reveal">
        <div class="visual-accent"></div>
        <div class="visual-box">
          <div class="label" style="margin-bottom: var(--space-6);">Why Vueports?</div>
          <h3 class="heading-lg" style="margin-bottom: var(--space-4);">We build software that actually works.</h3>
          <p class="body-base">No bloated code. No over-engineering. Just clean, scalable solutions that solve real problems and deliver measurable results.</p>
          <div class="about-values">
            <span class="value-tag">Performance First</span>
            <span class="value-tag">Clean Architecture</span>
            <span class="value-tag">Future-Proof</span>
            <span class="value-tag">User-Centric</span>
            <span class="value-tag">Transparent</span>
          </div>
        </div>
      </div>
      <div class="reveal">
        <span class="section-label">About Us</span>
        <h2 class="section-title" style="margin-bottom: var(--space-6);">Technology partners,<br>not just vendors.</h2>
        <p class="body-lg" style="margin-bottom: var(--space-6);">
          Vueports Solutions was founded on a simple belief: technology should make business easier, not harder. We partner with companies to build software that drives growth, reduces friction, and creates competitive advantage.
        </p>
        <p class="body-base" style="margin-bottom: var(--space-8);">
          Our team combines deep technical expertise with business acumen. We don't just write code — we solve problems, optimize processes, and help you make better decisions with data.
        </p>
        <a href="pages/about.php" class="btn-arrow">
          More About Us
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="section-sm">
  <div class="container">
    <div class="stats-grid reveal">
      <div class="stat-item">
        <div class="stat-value">150<span class="accent">+</span></div>
        <div class="stat-label">Projects Delivered</div>
      </div>
      <div class="stat-item">
        <div class="stat-value">98<span class="accent">%</span></div>
        <div class="stat-label">Client Satisfaction</div>
      </div>
      <div class="stat-item">
        <div class="stat-value">12<span class="accent">+</span></div>
        <div class="stat-label">Countries Served</div>
      </div>
      <div class="stat-item">
        <div class="stat-value">24<span class="accent">/7</span></div>
        <div class="stat-label">Support Available</div>
      </div>
    </div>
  </div>
</section>

<!-- Feature Cards Section -->
<section class="section">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">Our Approach</span>
      <h2 class="section-title">How we turn ideas<br>into reality.</h2>
    </div>

    <div class="grid-3" style="gap: var(--space-6);">
      <div class="feature-card accent-cyan reveal">
        <h3 class="card-title" style="color: var(--accent-cyan);">Discover</h3>
        <p class="card-desc">We start by understanding your business, your users, and your goals. Deep discovery leads to better solutions.</p>
        <a href="#" class="card-cta" style="color: var(--accent-cyan);">
          Our Process
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="feature-card accent-indigo reveal">
        <h3 class="card-title" style="color: var(--accent-indigo);">Build</h3>
        <p class="card-desc">Agile development with weekly demos. You see progress in real-time and can pivot whenever needed.</p>
        <a href="#" class="card-cta" style="color: var(--accent-indigo);">
          Tech Stack
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>

      <div class="feature-card accent-pink reveal">
        <h3 class="card-title" style="color: var(--accent-pink);">Launch</h3>
        <p class="card-desc">Smooth deployment with monitoring, documentation, and training. We don't disappear after go-live.</p>
        <a href="#" class="card-cta" style="color: var(--accent-pink);">
          Case Studies
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="section" style="background: var(--bg-surface);">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">Testimonials</span>
      <h2 class="section-title">Loved by teams<br>everywhere.</h2>
    </div>

    <div class="testimonials-grid">
      <div class="testimonial-card reveal">
        <p class="testimonial-quote">"Vueports transformed our legacy system into a modern platform in just 8 weeks. The team's technical depth and communication were exceptional."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">SK</div>
          <div>
            <div class="testimonial-name">Sarah Kimani</div>
            <div class="testimonial-role">CTO, FinFlow Africa</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card reveal">
        <p class="testimonial-quote">"Their AI agent reduced our customer support workload by 60%. It's like having a full-time employee that never sleeps."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">JM</div>
          <div>
            <div class="testimonial-name">James Mwangi</div>
            <div class="testimonial-role">Founder, ShopLocal</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card reveal">
        <p class="testimonial-quote">"The data pipeline they built handles millions of records daily without breaking a sweat. Best investment we've made."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">AN</div>
          <div>
            <div class="testimonial-name">Amina Njoroge</div>
            <div class="testimonial-role">Data Director, AgriTech</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="section cta-section">
  <div class="container">
    <div class="cta-section-inner reveal">
      <div class="cta-section-bg-text">Build.</div>
      <div class="cta-section-content">
        <h2 class="cta-section-title">Ready to build<br>something great?</h2>
        <p class="cta-section-desc">Book a free consultation and let's discuss how we can help your business grow with technology.</p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
          <a href="pages/consultation.php" class="btn btn-primary btn-lg">
            Book a Call
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
          <a href="pages/calculator.php" class="btn btn-secondary btn-lg">Price Calculator</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Large CTA Cards -->
<section class="section-sm">
  <div class="container">
    <div class="grid-3" style="gap: var(--space-6);">
      <a href="pages/consultation.php" class="cta-card-large reveal">
        <h3 class="cta-title">Book a Call</h3>
      </a>
      <a href="pages/calculator.php" class="cta-card-large reveal">
        <h3 class="cta-title">Get a Quote</h3>
      </a>
      <a href="pages/contact.php" class="cta-card-large reveal">
        <h3 class="cta-title">Send a Message</h3>
      </a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
