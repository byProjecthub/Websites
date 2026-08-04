<?php
declare(strict_types=1);

require_once 'includes/functions.php';

$pageTitle = 'Portfolio';
$pageDescription = 'View our featured projects and case studies.';

require_once 'includes/header.php';

// Fetch all active portfolio items
$projects = [];
if (function_exists('getPortfolioItems')) {
    $projects = getPortfolioItems(50, 'active');
}

// Fallback if DB is empty
if (empty($projects)) {
    $projects = [
        [
            'slug' => 'finlytics-dashboard',
            'title' => 'Finlytics Dashboard',
            'description' => 'Real-time financial analytics with multi-tenant architecture.','description' => 'Processing 11 analytical screens.',
            'service_type' => 'SaaS',
            'image' => '/images/Finlytics.png',
        ],
        [
            'slug' => 'reloventura-platform',
            'title' => 'Reloventura Platform',
            'description' => 'Booking engine with payment integration.',
            'service_type' => 'Web App','service_type' => 'BI Dashboard',
            'image' => '/images/reloventura1.png',
        ],
       
    ];
}
?>

<section class="services-hero" style="padding-top:140px;">
    <div class="container">
        <span class="section-tag">/ Portfolio</span>
        <h1>Our <span class="highlight">Work</span></h1>
        <p style="color:var(--text-secondary); font-size:1.125rem; margin-top:12px;">
            Projects that deliver real business results.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="portfolio-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
            <?php foreach ($projects as $project): ?>
            <div class="portfolio-card animate-on-scroll">
                <div class="portfolio-image">
                    <img src="<?= sanitize($project['image'] ?? 'assets/images/placeholder.svg') ?>" 
                         alt="<?= sanitize($project['title'] ?? 'Project') ?>" 
                         loading="lazy"
                         onerror="this.src='assets/images/placeholder.svg'">
                    <div class="portfolio-overlay">
                        <a href="portfolio-detail.php?slug=<?= sanitize($project['slug'] ?? '') ?>" class="btn btn-primary">View Project</a>
                    </div>
                </div>
                <div class="portfolio-info">
                    <span class="portfolio-tag"><?= sanitize($project['service_type'] ?? 'Project') ?></span>
                    <h3><?= sanitize($project['title'] ?? 'Untitled') ?></h3>
                    <p><?= sanitize($project['description'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
