<?php declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = ltrim($uri, '/');

// If requesting a specific PHP file directly, let it serve
if ($uri && $uri !== 'index.php' && file_exists($uri . '.php')) {
    include $uri . '.php';
    exit;
}

$pageTitle = 'Home';
$pageDescription = 'Vueports Solutions - Your IT Solutions Production Partner.';

require_once 'includes/functions.php';
require_once 'includes/header.php';


// Fetch services from database
$services = [];
if (function_exists('getAllServices')) {
    $services = getAllServices('active');
}
if (empty($services) && function_exists('getServices')) {
    $services = getServices(3);
}

// Fetch portfolio items for testimonials
$portfolio_items = [];
if (function_exists('getPortfolioItems')) {
    $portfolio_items = getPortfolioItems(6, 'active');
}

// Stats for counters
$stats = [
    ['count' => 12, 'label' => 'Projects Delivered', 'suffix' => '+'],
    ['count' => 8, 'label' => 'Enterprise Clients', 'suffix' => '+'],
    ['count' => 3, 'label' => 'Core Specializations', 'suffix' => ''],
    ['count' => 5, 'label' => 'Years Experience', 'suffix' => '+'],
];
?>

<!-- Hero Section -->
<section class="hero" id="home">
  <div class="container">
    <div class="hero-content">
      <div class="hero-label animate-fade-in-up">
        <span class="dot"></span>
        Available for new projects
      </div>
      <h1 class="hero-title animate-fade-in-up delay-100">
        Vueports Solutions is your best <span class="accent">IT Solutions Production Partner</span> —
        <span class="typewriter" id="typewriter" data-words='["Software Architect", "Data Engineer", "AI Agent Builder", "Cloud Specialist"]'></span><span class="cursor-blink">|</span>
      </h1>
      <p class="hero-subtitle animate-fade-in-up delay-200">
        We build <strong>custom software & web platforms</strong>, engineer <strong>data pipelines & analytics</strong>, and develop <strong>autonomous AI agents</strong> that automate your business. Secure, scalable, and built for real ROI.
      </p>
      <div class="hero-actions animate-fade-in-up delay-300">
        <a href="contact.php" class="btn btn-primary btn-lg">
          Start Your Project
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
        <a href="services.php" class="btn btn-secondary btn-lg">Explore Services</a>
      </div>
      <div class="hero-social" style="margin-top: var(--space-8);">
        <span class="hero-social-text" style="font-size: var(--text-sm); color: var(--text-muted); margin-right: var(--space-4);">Follow us for insights</span>
        <div class="social-links" style="display: flex; gap: var(--space-3);">
          <a href="https://github.com/byprojecthub" class="social-link" aria-label="GitHub" target="_blank" rel="noopener" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-subtle); border-radius: var(--radius-full); color: var(--text-muted); transition: all var(--transition-fast);">
            <i class="fab fa-github"></i>
          </a>
          <a href="https://www.linkedin.com/in/njabulo-dlamini-58b66a268/" class="social-link" aria-label="LinkedIn" target="_blank" rel="noopener" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-subtle); border-radius: var(--radius-full); color: var(--text-muted); transition: all var(--transition-fast);">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="https://x.com/Colourerr" class="social-link" aria-label="Twitter" target="_blank" rel="noopener" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-subtle); border-radius: var(--radius-full); color: var(--text-muted); transition: all var(--transition-fast);">
            <i class="fab fa-twitter"></i>
          </a>
        </div>
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

<!-- Stats Bar -->
<section class="section-sm" id="stats">
  <div class="container">
    <div class="stats-grid reveal">
      <?php foreach ($stats as $stat): ?>
      <div class="stat-item" data-count="<?= $stat['count'] ?>" data-suffix="<?= sanitize($stat['suffix']) ?>">
        <div class="stat-value">0<?= sanitize($stat['suffix']) ?></div>
        <div class="stat-label"><?= sanitize($stat['label']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Services Preview -->
<section class="section" id="services">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">Solutions</span>
      <h2 class="section-title">High-Value Services That <span class="accent">Scale</span></h2>
      <p class="section-desc">We don't just write code. We architect revenue-generating systems.</p>
    </div>
    <div class="services-grid">
      <?php if (!empty($services)): ?>
        <?php
        $accent_classes = ['accent-cyan', 'accent-blue', 'accent-violet', 'accent-pink', 'accent-amber', 'accent-emerald'];
        foreach (array_slice($services, 0, 3) as $i => $svc):
          $features = json_decode($svc['features'] ?? '[]', true);
          $accent = $accent_classes[$i % count($accent_classes)];
        ?>
        <div class="service-card <?= $accent ?> reveal">
          <div class="service-icon">
            <i class="fas <?= sanitize($svc['icon'] ?? 'fa-code') ?>"></i>
          </div>
          <h3 class="service-title"><?= sanitize($svc['title']) ?></h3>
          <p class="service-desc"><?= sanitize($svc['description']) ?></p>
          <?php if (!empty($features)): ?>
          <ul style="display: flex; flex-direction: column; gap: var(--space-2); margin-bottom: var(--space-6);">
            <?php foreach (array_slice($features, 0, 3) as $f): ?>
              <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <?= sanitize($f) ?>
              </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
          <a href="service-detail.php?slug=<?= sanitize($svc['slug']) ?>" class="service-link">
            Learn more
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback static cards if no services in DB -->
        <div class="service-card accent-cyan reveal">
          <div class="service-icon"><i class="fas fa-laptop-code"></i></div>
          <h3 class="service-title">Custom Software & Web</h3>
          <p class="service-desc">SaaS, APIs, legacy modernization, and cloud-native web applications.</p>
          <ul style="display: flex; flex-direction: column; gap: var(--space-2); margin-bottom: var(--space-6);">
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>Full-stack development</li>
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>API architecture</li>
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>Cloud deployment</li>
          </ul>
          <a href="services.php" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
        </div>
        <div class="service-card accent-blue reveal">
          <div class="service-icon"><i class="fas fa-database"></i></div>
          <h3 class="service-title">Data Engineering</h3>
          <p class="service-desc">Data lakes, ETL pipelines, BI dashboards, and predictive analytics.</p>
          <ul style="display: flex; flex-direction: column; gap: var(--space-2); margin-bottom: var(--space-6);">
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>ETL/ELT pipelines</li>
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>Data warehousing</li>
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>Power BI / Looker</li>
          </ul>
          <a href="services.php" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
        </div>
        <div class="service-card accent-violet reveal">
          <div class="service-icon"><i class="fas fa-robot"></i></div>
          <h3 class="service-title">AI Agent Development</h3>
          <p class="service-desc">Autonomous agents, workflow automation, and LLM integrations.</p>
          <ul style="display: flex; flex-direction: column; gap: var(--space-2); margin-bottom: var(--space-6);">
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>LLM integration</li>
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>RAG knowledge bases</li>
            <li style="font-size: var(--text-sm); color: var(--text-secondary); display: flex; align-items: center; gap: var(--space-2);"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--accent-emerald)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>Autonomous agents</li>
          </ul>
          <a href="services.php" class="service-link">Learn more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Portfolio -->
<section class="section" style="background: var(--bg-surface);" id="portfolio">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">/ Portfolio</span>
      <h2 class="section-title">Featured <span class="accent">Work</span></h2>
    </div>
    <div class="portfolio-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-6);">
      <?php if (!empty($portfolio_items)): ?>
        <?php foreach (array_slice($portfolio_items, 0, 3) as $index => $item): ?>
        <div class="card reveal" style="overflow: hidden; padding: 0;">
          <div class="portfolio-image" style="position: relative; overflow: hidden;">
            <?php if (!empty($item['image'])): ?>
              <img src="<?= sanitize($item['image']) ?>" alt="<?= sanitize($item['title']) ?>" loading="lazy" style="width: 100%; height: 220px; object-fit: cover;">
            <?php else: ?>
              <img src="images/1694008468595.jpeg" alt="<?= sanitize($item['title']) ?>" loading="lazy" style="width: 100%; height: 220px; object-fit: cover;">
            <?php endif; ?>
            <div class="portfolio-overlay" style="position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity var(--transition-base);">
              <a href="portfolio-detail.php?slug=<?= sanitize($item['slug']) ?>" class="btn btn-primary">View Project</a>
            </div>
          </div>
          <div style="padding: var(--space-6);">
            <span style="font-size: var(--text-xs); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: var(--accent-indigo);"><?= sanitize($item['service_type'] ?? 'Project') ?></span>
            <h3 style="font-size: var(--text-xl); font-weight: 700; margin-top: var(--space-2); margin-bottom: var(--space-2);"><?= sanitize($item['title']) ?></h3>
            <p style="font-size: var(--text-sm); color: var(--text-secondary); line-height: 1.6;"><?= sanitize($item['description'] ?? '') ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback static portfolio cards -->
        <div class="card reveal" style="overflow: hidden; padding: 0;">
          <div style="position: relative; overflow: hidden;">
            <img src="/images/Finlytics.png" alt="Finlytics" loading="lazy" style="width: 100%; height: 220px; object-fit: cover;">
            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity var(--transition-base);" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
              <a href="portfolio.php" class="btn btn-primary">View Project</a>
            </div>
          </div>
          <div style="padding: var(--space-6);">
            <span style="font-size: var(--text-xs); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: var(--accent-indigo);">SaaS</span>
            <h3 style="font-size: var(--text-xl); font-weight: 700; margin-top: var(--space-2); margin-bottom: var(--space-2);">Finlytics Dashboard</h3>
            <p style="font-size: var(--text-sm); color: var(--text-secondary); line-height: 1.6;">Real-time financial analytics with multi-tenant architecture. Processing 11 analytical Screens.</p>
          </div>
        </div>
        <div class="card reveal" style="overflow: hidden; padding: 0;">
          <div style="position: relative; overflow: hidden;">
            <img src="/images/reloventura1.png" alt="Reloventura" loading="lazy" style="width: 100%; height: 220px; object-fit: cover;">
            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity var(--transition-base);" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
              <a href="portfolio.php" class="btn btn-primary">View Project</a>
            </div>
          </div>
          <div style="padding: var(--space-6);">
            <span style="font-size: var(--text-xs); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: var(--accent-indigo);">Web App</span>
            <h3 style="font-size: var(--text-xl); font-weight: 700; margin-top: var(--space-2); margin-bottom: var(--space-2);">Reloventura Platform</h3>
            <p style="font-size: var(--text-sm); color: var(--text-secondary); line-height: 1.6;">Booking engine with payment integration.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="center-btn" style="text-align: center; margin-top: var(--space-10);">
      <a href="portfolio.php" class="btn btn-secondary">
        View All Projects
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</section>

<!-- Pricing -->
<section class="section" id="pricing">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">Pricing</span>
      <h2 class="section-title">Investment <span class="accent">Tiers</span></h2>
      <p class="section-desc">Transparent pricing for high-impact solutions and functional frameworks.</p>
    </div>
    <div class="pricing-grid">
      <div class="pricing-card reveal">
        <h3 class="pricing-name">Starter</h3>
        <p class="pricing-desc">Perfect for MVPs, small web apps, and single AI agents.</p>
        <div class="pricing-price">R13,000<span>/project</span></div>
        <p class="pricing-period">One-time payment</p>
        <div class="pricing-features">
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 5-Page Website or Simple SaaS MVP</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Basic Data Pipeline Setup</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 1 Custom AI Agent / Chatbot</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 30 Days Support</div>
          <div class="pricing-feature" style="color: var(--text-muted);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Advanced Analytics</div>
        </div>
        <a href="calculator.php" class="btn btn-secondary" style="width: 100%;">Get Started</a>
      </div>
      <div class="pricing-card featured reveal">
        <h3 class="pricing-name">Professional</h3>
        <p class="pricing-desc">Growing businesses needing robust platforms and data intelligence.</p>
        <div class="pricing-price">R25,000<span>/project</span></div>
        <p class="pricing-period">One-time payment</p>
        <div class="pricing-features">
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Full-Stack Web Application</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Data Warehouse + BI Dashboard</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Multi-Agent AI Workflow</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> API Development & Integration</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 90 Days Support</div>
        </div>
        <a href="calculator.php" class="btn btn-primary" style="width: 100%;">Get Started</a>
      </div>
      <div class="pricing-card reveal">
        <h3 class="pricing-name">Enterprise</h3>
        <p class="pricing-desc">Large-scale systems, enterprise data platforms, and autonomous operations.</p>
        <div class="pricing-price">Custom<span>/retainer</span></div>
        <p class="pricing-period">Contact us for a quote</p>
        <div class="pricing-features">
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Unlimited Scope & Custom Architecture</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Real-time Data Engineering</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Autonomous AI Agent Ecosystems</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Dedicated DevOps & Support</div>
          <div class="pricing-feature"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Monthly Retainer Available</div>
        </div>
        <a href="contact.php?plan=enterprise" class="btn btn-secondary" style="width: 100%;">Contact Us</a>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="section" style="background: var(--bg-surface);" id="testimonials">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">Testimonials</span>
      <h2 class="section-title">Client <span class="accent">Results</span></h2>
    </div>
    <div class="testimonials-slider">
      <div class="testimonials-track" id="testimonialsTrack" style="display: flex; gap: var(--space-6); overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: var(--space-4);">
        <?php if (!empty($portfolio_items)): ?>
          <?php foreach ($portfolio_items as $t):
            if (empty($t['testimonial'])) continue;
          ?>
          <div class="testimonial-card reveal" style="min-width: 340px; scroll-snap-align: start;">
            <div style="font-size: var(--text-3xl); color: var(--accent-indigo); margin-bottom: var(--space-4);"><i class="fas fa-quote-left"></i></div>
            <p class="testimonial-quote">"<?= sanitize($t['testimonial']) ?>"</p>
            <div class="testimonial-author">
              <?php if (!empty($t['image'])): ?>
              <img src="<?= sanitize($t['image']) ?>" alt="<?= sanitize($t['client_name'] ?? 'Client') ?>" class="testimonial-avatar" loading="lazy" style="width: 48px; height: 48px; border-radius: var(--radius-full); object-fit: cover;">
              <?php else: ?>
              <div class="testimonial-avatar" style="background: var(--bg-surface-elevated); border: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: center; color: var(--accent-indigo); font-weight: 700; font-size: var(--text-sm); width: 48px; height: 48px; border-radius: var(--radius-full);">
                <?= strtoupper(substr($t['client_name'] ?? 'C', 0, 1)) ?>
              </div>
              <?php endif; ?>
              <div>
                <div class="testimonial-name"><?= sanitize($t['client_name'] ?? 'Client') ?></div>
                <div class="testimonial-role"><?= sanitize($t['title'] ?? '') ?></div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Fallback testimonials -->
          <div class="testimonial-card reveal" style="min-width: 340px; scroll-snap-align: start;">
            <div style="font-size: var(--text-3xl); color: var(--accent-indigo); margin-bottom: var(--space-4);"><i class="fas fa-quote-left"></i></div>
            <p class="testimonial-quote">"Vueports Solutions did an amazing work with our web-app, everything he did to optimize our software help us to reduce our loading speed by 56%"</p>
            <div class="testimonial-author">
              <div class="testimonial-avatar" style="background: var(--bg-surface-elevated); border: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: center; color: var(--accent-indigo); font-weight: 700; font-size: var(--text-sm); width: 48px; height: 48px; border-radius: var(--radius-full);">U</div>
              <div>
                <div class="testimonial-name">USANDA DUKADA</div>
                <div class="testimonial-role">IoT Manager at JPP Municipality</div>
              </div>
            </div>
          </div>
          <div class="testimonial-card reveal" style="min-width: 340px; scroll-snap-align: start;">
            <div style="font-size: var(--text-3xl); color: var(--accent-indigo); margin-bottom: var(--space-4);"><i class="fas fa-quote-left"></i></div>
            <p class="testimonial-quote">"We've never had come this far without Vueports Solutions's great attention to detail and care for the final product"</p>
            <div class="testimonial-author">
              <div class="testimonial-avatar" style="background: var(--bg-surface-elevated); border: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: center; color: var(--accent-indigo); font-weight: 700; font-size: var(--text-sm); width: 48px; height: 48px; border-radius: var(--radius-full);">T</div>
              <div>
                <div class="testimonial-name">TEBOGO MADILENG</div>
                <div class="testimonial-role">CEO at AlphDotX</div>
              </div>
            </div>
          </div>
          <div class="testimonial-card reveal" style="min-width: 340px; scroll-snap-align: start;">
            <div style="font-size: var(--text-3xl); color: var(--accent-indigo); margin-bottom: var(--space-4);"><i class="fas fa-quote-left"></i></div>
            <p class="testimonial-quote">"I think Vueports Solutions was essential to our product because he truly cared to deliver world-class work results"</p>
            <div class="testimonial-author">
              <div class="testimonial-avatar" style="background: var(--bg-surface-elevated); border: 1px solid var(--border-subtle); display: flex; align-items: center; justify-content: center; color: var(--accent-indigo); font-weight: 700; font-size: var(--text-sm); width: 48px; height: 48px; border-radius: var(--radius-full);">I</div>
              <div>
                <div class="testimonial-name">ITUMELENG NKABINDE</div>
                <div class="testimonial-role">Head Designer at I.N Designs</div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="slider-controls" style="display: flex; align-items: center; justify-content: center; gap: var(--space-4); margin-top: var(--space-8);">
        <button class="slider-btn" id="prevBtn" aria-label="Previous testimonial" style="width: 44px; height: 44px; border-radius: var(--radius-full); border: 1px solid var(--border-subtle); background: var(--bg-surface); color: var(--text-primary); display: flex; align-items: center; justify-content: center; transition: all var(--transition-fast); cursor: pointer;">
          <i class="fas fa-chevron-left"></i>
        </button>
        <div class="slider-dots" id="sliderDots"></div>
        <button class="slider-btn" id="nextBtn" aria-label="Next testimonial" style="width: 44px; height: 44px; border-radius: var(--radius-full); border: 1px solid var(--border-subtle); background: var(--bg-surface); color: var(--text-primary); display: flex; align-items: center; justify-content: center; transition: all var(--transition-fast); cursor: pointer;">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="section" id="faq">
  <div class="container">
    <div class="section-header center reveal">
      <span class="section-label">FAQ</span>
      <h2 class="section-title">Frequently Asked <span class="accent">Questions</span></h2>
      <p class="section-desc">Everything you need to know about working with us.</p>
    </div>
    <div class="faq-list reveal">
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          <span>What is your typical project timeline?</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Most projects range from 4-16 weeks depending on complexity. MVPs typically take 4-8 weeks, while enterprise solutions may require 12-16 weeks. We provide detailed timelines during our scoping session.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          <span>Do you offer ongoing support after launch?</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Yes! We offer maintenance retainers and support packages. Starter projects include 30 days of support, Professional includes 90 days, and Enterprise clients get dedicated DevOps support with monthly retainers available.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          <span>What technologies do you specialize in?</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>We specialize in modern full-stack development (React, Vue, Node.js, Python), cloud infrastructure (AWS, Azure, GCP), data engineering (Spark, Kafka, Snowflake), and AI/ML (OpenAI, Claude, LangChain, custom model training).</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          <span>How do you handle project pricing?</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>We offer transparent fixed-price projects based on detailed scoping. For ongoing work, we have monthly retainer options. All pricing is in ZAR and we accept payments via PayFast, EFT, or bank transfer.</p>
        </div>
      </div>
      <div class="faq-item">
        <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">
          <span>Can you work with our existing team?</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="faq-answer">
          <p>Absolutely. We regularly collaborate with in-house teams, acting as an extension of your engineering department. We use agile methodologies and integrate with your existing workflows, tools, and communication channels.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section cta-section">
  <div class="container">
    <div class="cta-section-inner reveal">
      <div class="cta-section-bg-text">Build.</div>
      <div class="cta-section-content">
        <h2 class="cta-section-title">Ready to build your next revenue engine?</h2>
        <p class="cta-section-desc">Let's architect your custom software, data platform, or AI agent ecosystem.</p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
          <a href="calculator.php" class="btn btn-primary btn-lg">
            Start a Project
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
          <a href="contact.php" class="btn btn-secondary btn-lg">Contact Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
