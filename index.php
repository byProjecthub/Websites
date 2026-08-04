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
    <div class="hero-bg">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
    </div>
    <div class="container hero-wrapper">
        
        <!-- Left: Existing content -->
        <div class="hero-content">
            <h1 class="hero-title">
                Vueports Solutions is your best <span class="highlight gradient-text">IT Solutions Production Partner</span> — 
                <span class="typewriter" id="typewriter" data-words='["Software Architect", "Data Engineer", "AI Agent Builder", "Cloud Specialist"]'></span><span class="cursor-blink">|</span>
            </h1>
            <p class="hero-description">
                We build <strong>custom software & web platforms</strong>, engineer <strong>data pipelines & analytics</strong>, and develop <strong>autonomous AI agents</strong> that automate your business. Secure, scalable, and built for real ROI.
            </p>
            <div class="hero-actions">
                <a href="contact.php" class="btn btn-primary btn-lg">Start Your Project <i class="fas fa-arrow-right"></i></a>
                <a href="services.php" class="btn btn-outline btn-lg">Explore Services <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="hero-social">
                <span class="hero-social-text">Follow us for insights</span>
                <div class="social-links">
                    <a href="https://github.com/byprojecthub" class="social-link" aria-label="GitHub" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    <a href="https://www.linkedin.com/in/njabulo-dlamini-58b66a268/" class="social-link" aria-label="LinkedIn" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://x.com/Colourerr" class="social-link" aria-label="Twitter" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- Right: Floating visual cards -->
        <div class="hero-visual">
            <div class="hero-card hero-card--back">
                <div class="hero-card__header">
                    <div class="hero-card__dot"></div>
                    <div class="hero-card__dot"></div>
                    <div class="hero-card__dot"></div>
                </div>
                <div class="hero-card__body">
                    <div class="hero-card__row">
                        <div class="hero-card__avatar"></div>
                        <div class="hero-card__lines">
                            <div class="hero-card__line hero-card__line--long"></div>
                            <div class="hero-card__line hero-card__line--short"></div>
                        </div>
                    </div>
                    <div class="hero-card__chart">
                        <div class="hero-card__bar" style="height:40%"></div>
                        <div class="hero-card__bar" style="height:70%"></div>
                        <div class="hero-card__bar" style="height:55%"></div>
                        <div class="hero-card__bar" style="height:90%"></div>
                        <div class="hero-card__bar" style="height:65%"></div>
                    </div>
                </div>
            </div>

            <div class="hero-card hero-card--mid">
                <div class="hero-card__header">
                    <div class="hero-card__dot"></div>
                    <div class="hero-card__dot"></div>
                    <div class="hero-card__dot"></div>
                </div>
                <div class="hero-card__body">
                    <div class="hero-card__badge">AI Agent</div>
                    <div class="hero-card__title">Autonomous Workflow</div>
                    <div class="hero-card__line hero-card__line--long"></div>
                    <div class="hero-card__line hero-card__line--med"></div>
                    <div class="hero-card__status">
                        <span class="hero-card__pulse"></span>
                        <span>Running</span>
                    </div>
                </div>
            </div>

            <div class="hero-card hero-card--front">
                <div class="hero-card__header">
                    <div class="hero-card__dot"></div>
                    <div class="hero-card__dot"></div>
                    <div class="hero-card__dot"></div>
                </div>
                <div class="hero-card__body">
                    <div class="hero-card__metric">
                        <div class="hero-card__number">99.9%</div>
                        <div class="hero-card__label">Uptime</div>
                    </div>
                    <div class="hero-card__progress">
                        <div class="hero-card__progress-bar"></div>
                    </div>
                    <div class="hero-card__row" style="margin-top:16px; gap:8px;">
                        <span class="hero-card__tag">Cloud</span>
                        <span class="hero-card__tag">Secure</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Stats Bar -->
<section class="stats-bar" id="stats">
    <div class="container">
        <div class="stats-grid stagger-children">
            <?php foreach ($stats as $stat): ?>
            <div class="stat-item" data-count="<?= $stat['count'] ?>" data-suffix="<?= sanitize($stat['suffix']) ?>">
                <span class="stat-number">0<?= sanitize($stat['suffix']) ?></span>
                <span class="stat-label"><?= sanitize($stat['label']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Services Preview -->
<section class="section" id="services">
    <div class="container">
        <div class="section-header center">
            <span class="section-tag">Solutions</span>
            <h2 class="section-title">High-Value Services That <span class="highlight gradient-text">Scale</span></h2>
            <p class="section-desc">We don't just write code. We architect revenue-generating systems.</p>
        </div>
        <div class="services-grid grid grid-cols-3">
            <?php if (!empty($services)): ?>
                <?php foreach (array_slice($services, 0, 3) as $svc): 
                    $features = json_decode($svc['features'] ?? '[]', true);
                ?>
                <div class="card card-hover animate-on-scroll">
                    <div class="service-icon">
                        <i class="fas <?= sanitize($svc['icon'] ?? 'fa-code') ?>"></i>
                    </div>
                    <h3><?= sanitize($svc['title']) ?></h3>
                    <p><?= sanitize($svc['description']) ?></p>
                    <?php if (!empty($features)): ?>
                    <ul class="service-features">
                        <?php foreach (array_slice($features, 0, 3) as $f): ?>
                            <li><i class="fas fa-check-circle"></i><?= sanitize($f) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <a href="service-detail.php?slug=<?= sanitize($svc['slug']) ?>" class="service-link">
                        Learn more <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static cards if no services in DB -->
                <div class="card card-hover animate-on-scroll">
                    <div class="service-icon"><i class="fas fa-laptop-code"></i></div>
                    <h3>Custom Software & Web</h3>
                    <p>SaaS, APIs, legacy modernization, and cloud-native web applications.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i>Full-stack development</li>
                        <li><i class="fas fa-check-circle"></i>API architecture</li>
                        <li><i class="fas fa-check-circle"></i>Cloud deployment</li>
                    </ul>
                    <a href="services.php" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card card-hover animate-on-scroll">
                    <div class="service-icon"><i class="fas fa-database"></i></div>
                    <h3>Data Engineering</h3>
                    <p>Data lakes, ETL pipelines, BI dashboards, and predictive analytics.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i>ETL/ELT pipelines</li>
                        <li><i class="fas fa-check-circle"></i>Data warehousing</li>
                        <li><i class="fas fa-check-circle"></i>Power BI / Looker</li>
                    </ul>
                    <a href="services.php" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card card-hover animate-on-scroll">
                    <div class="service-icon"><i class="fas fa-robot"></i></div>
                    <h3>AI Agent Development</h3>
                    <p>Autonomous agents, workflow automation, and LLM integrations.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check-circle"></i>LLM integration</li>
                        <li><i class="fas fa-check-circle"></i>RAG knowledge bases</li>
                        <li><i class="fas fa-check-circle"></i>Autonomous agents</li>
                    </ul>
                    <a href="services.php" class="service-link">Learn more <i class="fas fa-arrow-right"></i></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Portfolio -->
<section class="portfolio section" id="portfolio">
    <div class="container">
        <div class="section-header center">
            <span class="section-tag">/ Portfolio</span>
            <h2 class="section-title">Featured <span class="highlight">Work</span></h2>
        </div>
        <div class="portfolio-grid">
            <?php if (!empty($portfolio_items)): ?>
                <?php foreach (array_slice($portfolio_items, 0, 3) as $index => $item): ?>
                <div class="portfolio-card <?= $index === 0 ? 'featured' : '' ?> animate-on-scroll">
                    <div class="portfolio-image">
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= sanitize($item['image']) ?>" alt="<?= sanitize($item['title']) ?>" loading="lazy">
                        <?php else: ?>
                            <img src="images/1694008468595.jpeg" alt="<?= sanitize($item['title']) ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="portfolio-overlay"> 
                            <a href="portfolio-detail.php?slug=<?= sanitize($item['slug']) ?>" class="btn btn-primary">View Project</a>
                        </div>
                    </div>
                    <div class="portfolio-info">
                        <span class="portfolio-tag"><?= sanitize($item['service_type'] ?? 'Project') ?></span>
                        <h3><?= sanitize($item['title']) ?></h3>
                        <p><?= sanitize($item['description'] ?? '') ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static portfolio cards -->
                <div class="portfolio-card featured animate-on-scroll">
                    <div class="portfolio-image">
                        <img src="/images/Finlytics.png" alt="Finlytics" loading="lazy">
                        <div class="portfolio-overlay"><a href="portfolio.php" class="btn btn-primary">View Project</a></div>
                    </div>
                    <div class="portfolio-info">
                        <span class="portfolio-tag">SaaS</span>
                        <span class="portfolio-tag">BI Dashboard</span>
                        <h3>Finlytics Dashboard</h3>
                        <p>Real-time financial analytics with multi-tenant architecture.</p>
                        <p>Processing 11 analytical Screens.</p>
                    </div>
                </div>
                <div class="portfolio-card animate-on-scroll">
                    <div class="portfolio-image">
                        <img src="/images/reloventura1.png" alt="Reloventura" loading="lazy">
                        <div class="portfolio-overlay"><a href="portfolio.php" class="btn btn-primary">View Project</a></div>
                    </div>
                    <div class="portfolio-info">
                        <span class="portfolio-tag">Web App</span>
                        <h3>Reloventura Platform</h3>
                        <p>Booking engine with payment integration.</p>
                    </div>
                </div>
          <?php endif; ?>
        </div>
        <div class="center-btn">
            <a href="portfolio.php" class="btn btn-outline">View All Projects <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- Pricing -->
<section class="section" id="pricing">
    <div class="container">
        <div class="section-header center">
            <span class="section-tag">Pricing</span>
            <h2 class="section-title">Investment <span class="highlight gradient-text">Tiers</span></h2>
            <p class="section-desc">Transparent pricing for high-impact solutions and functional frameworks.</p>
        </div>
        <div class="pricing-grid">
            <div class="card card-hover animate-on-scroll">
                <h3 style="font-size: var(--font-size-xl);">Starter</h3>
                <div class="pricing-price">R13,000<span>/project</span></div>
                <p class="pricing-desc">Perfect for MVPs, small web apps, and single AI agents. These solutions are integrated with quality standards.</p>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> 5-Page Website or Simple SaaS MVP</li>
                    <li><i class="fas fa-check"></i> Basic Data Pipeline Setup</li>
                    <li><i class="fas fa-check"></i> 1 Custom AI Agent / Chatbot</li>
                    <li><i class="fas fa-check"></i> 30 Days Support</li>
                    <li class="not-included"><i class="fas fa-times"></i> Advanced Analytics</li>
                </ul>
                <a href="calculator.php" class="btn btn-outline" style="width: 100%;">Get Started</a>
            </div>
            <div class="card card-featured animate-on-scroll">
                <h3 style="font-size: var(--font-size-xl);">Professional</h3>
                <div class="pricing-price">R25,000<span>/project</span></div>
                <p class="pricing-desc">Growing businesses needing robust platforms and data intelligence for quality daily functionality.</p>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Full-Stack Web Application</li>
                    <li><i class="fas fa-check"></i> Data Warehouse + BI Dashboard</li>
                    <li><i class="fas fa-check"></i> Multi-Agent AI Workflow</li>
                    <li><i class="fas fa-check"></i> API Development & Integration</li>
                    <li><i class="fas fa-check"></i> 90 Days Support</li>
                </ul>
                <a href="calculator.php" class="btn btn-primary" style="width: 100%;">Get Started</a>
            </div>
            <div class="card card-hover animate-on-scroll">
                <h3 style="font-size: var(--font-size-xl);">Enterprise</h3>
                <div class="pricing-price">Custom<span>/retainer</span></div>
                <p class="pricing-desc">Large-scale systems, enterprise data platforms, and autonomous operations. This is fully efficient solution that elevates company functions.</p>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Unlimited Scope & Custom Architecture</li>
                    <li><i class="fas fa-check"></i> Real-time Data Engineering</li>
                    <li><i class="fas fa-check"></i> Autonomous AI Agent Ecosystems</li>
                    <li><i class="fas fa-check"></i> Dedicated DevOps & Support</li>
                    <li><i class="fas fa-check"></i> Monthly Retainer Available</li>
                </ul>
                <a href="contact.php?plan=enterprise" class="btn btn-outline" style="width: 100%;">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials section" id="testimonials">
    <div class="container">
        <div class="section-header center">
            <span class="section-tag">Testimonials</span>
            <h2 class="section-title">Client <span class="highlight gradient-text">Results</span></h2>
        </div>
        <div class="testimonials-slider">
            <div class="testimonials-track" id="testimonialsTrack">
                <?php if (!empty($portfolio_items)): ?>
                    <?php foreach ($portfolio_items as $t): 
                        if (empty($t['testimonial'])) continue;
                    ?>
                    <div class="testimonial-card">
                        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                        <p class="testimonial-text">"<?= sanitize($t['testimonial']) ?>"</p>
                        <div class="testimonial-author">
                            <?php if (!empty($t['image'])): ?>
                            <img src="<?= sanitize($t['image']) ?>" alt="<?= sanitize($t['client_name'] ?? 'Client') ?>" class="testimonial-avatar" loading="lazy">
                            <?php else: ?>
                            <div class="testimonial-avatar" style="background: var(--bg-active); display: flex; align-items: center; justify-content: center; color: var(--color-accent); font-weight: 700; font-size: 1.5rem;">
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
                    <div class="testimonial-card">
                        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                        <p class="testimonial-text">"Vueports Solutions did an amazing work with our web-app, everything he did to optimize our software help us to reduce our loading speed by 56%"</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar" style="background: var(--bg-active); display: flex; align-items: center; justify-content: center; color: var(--color-accent); font-weight: 700; font-size: 1.5rem;">U</div>
                            <div>
                                <div class="testimonial-name">USANDA DUKADA</div>
                                <div class="testimonial-role">IoT Manager at JPP Municipality</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                        <p class="testimonial-text">"We've never had come this far without Vueports Solutions's great attention to detail and care for the final product"</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar" style="background: var(--bg-active); display: flex; align-items: center; justify-content: center; color: var(--color-accent); font-weight: 700; font-size: 1.5rem;">T</div>
                            <div>
                                <div class="testimonial-name">TEBOGO MADILENG</div>
                                <div class="testimonial-role">CEO at AlphDotX</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
                        <p class="testimonial-text">"I think Vueports Solutions was essential to our product because he truly cared to deliver world-class work results"</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar" style="background: var(--bg-active); display: flex; align-items: center; justify-content: center; color: var(--color-accent); font-weight: 700; font-size: 1.5rem;">I</div>
                            <div>
                                <div class="testimonial-name">ITUMELENG NKABINDE</div>
                                <div class="testimonial-role">Head Designer at I.N Designs</div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="slider-controls">
                <button class="slider-btn" id="prevBtn" aria-label="Previous testimonial"><i class="fas fa-chevron-left"></i></button>
                <div class="slider-dots" id="sliderDots"></div>
                <button class="slider-btn" id="nextBtn" aria-label="Next testimonial"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-header center">
            <span class="section-tag">FAQ</span>
            <h2 class="section-title">Frequently Asked <span class="highlight gradient-text">Questions</span></h2>
            <p class="section-desc">Everything you need to know about working with us.</p>
        </div>
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is your typical project timeline?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Most projects range from 4-16 weeks depending on complexity. MVPs typically take 4-8 weeks, while enterprise solutions may require 12-16 weeks. We provide detailed timelines during our scoping session.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer ongoing support after launch?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! We offer maintenance retainers and support packages. Starter projects include 30 days of support, Professional includes 90 days, and Enterprise clients get dedicated DevOps support with monthly retainers available.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>What technologies do you specialize in?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We specialize in modern full-stack development (React, Vue, Node.js, Python), cloud infrastructure (AWS, Azure, GCP), data engineering (Spark, Kafka, Snowflake), and AI/ML (OpenAI, Claude, LangChain, custom model training).</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>How do you handle project pricing?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We offer transparent fixed-price projects based on detailed scoping. For ongoing work, we have monthly retainer options. All pricing is in ZAR and we accept payments via PayFast, EFT, or bank transfer.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can you work with our existing team?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Absolutely. We regularly collaborate with in-house teams, acting as an extension of your engineering department. We use agile methodologies and integrate with your existing workflows, tools, and communication channels.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">Ready to build your next revenue engine?</h2>
        <p class="cta-desc">Let's architect your custom software, data platform, or AI agent ecosystem.</p>
        <a href="calculator.php" class="btn btn-primary btn-lg">Start a Project <i class="fas fa-arrow-right"></i></a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
