<?php
declare(strict_types=1);
require_once 'includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) redirect('services.php');

$db = db();
$service = null;
if ($db) {
    $stmt = $db->prepare("SELECT * FROM services WHERE slug = ? AND status = 'active'");
    $stmt->execute([$slug]);
    $service = $stmt->fetch();
}

if (!$service) redirect('services.php');

$pageTitle = $service['title'];
require_once 'includes/header.php';
$features = json_decode($service['features'] ?? '[]', true);

// Related services
$related = [];
if ($db) {
    $stmt = $db->prepare("SELECT * FROM services WHERE slug != ? AND status = 'active' ORDER BY RAND() LIMIT 2");
    $stmt->execute([$slug]);
    $related = $stmt->fetchAll();
}
?>

<section class="services-hero" style="padding-top: 140px;">
    <div class="container">
        <span class="section-tag"><?= sanitize($service['title']) ?></span>
        <h1><?= sanitize($service['title']) ?></h1>
        <p><?= sanitize($service['description']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="service-detail-card" style="border-bottom: none; padding-bottom: 0;">
            <div class="service-detail-visual">
                <i class="fas <?= sanitize($service['icon']) ?>"></i>
            </div>
            <div class="service-detail-content">
                <h2>Overview</h2>
                <p><?= nl2br(sanitize($service['long_description'])) ?></p>
                
                <h3 style="margin-top: var(--space-6); margin-bottom: var(--space-4); font-size: var(--font-size-xl);">What You Get</h3>
                <ul class="feature-list">
                    <?php foreach ($features as $f): ?>
                    <li><i class="fas fa-check-circle"></i> <?= sanitize($f) ?></li>
                    <?php endforeach; ?>
                </ul>
                
                <div style="margin: var(--space-6) 0; padding: var(--space-5); background: var(--bg-secondary); border-radius: var(--border-radius-lg); border-left: 4px solid var(--color-accent);">
                    <strong style="color: var(--text-primary); display: block; margin-bottom: var(--space-2);">Investment Range:</strong>
                    <span style="font-size: var(--font-size-lg); color: var(--color-accent); font-weight: 700;"><p>R<?= sanitize($service['price_min']) ?> - </p><p>R<?= sanitize($service['price_max']) ?></p></span>
                    <p style="margin-top: var(--space-2); font-size: var(--font-size-sm); color: var(--text-muted);">Final quotes depend on scope, integrations, and timeline.</p>
                </div>
                
                <div style="display: flex; gap: var(--space-4); flex-wrap: wrap;">
                    <a href="contact.php?service=<?= sanitize($service['slug']) ?>" class="btn btn-primary btn-lg">
                        Discuss Your Project <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="calculator.php?service=<?= sanitize($service['slug']) ?>" class="btn btn-outline btn-lg">
                        <i class="fas fa-calculator"></i> Get Estimate
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Related Services -->
        <?php if (!empty($related)): ?>
        <div style="margin-top: var(--space-16);">
            <h3 style="text-align: center; margin-bottom: var(--space-8); font-size: var(--font-size-2xl);">Explore Related Services</h3>
            <div class="grid grid-cols-2" style="gap: var(--space-6); max-width: 800px; margin: 0 auto;">
                <?php foreach ($related as $r): ?>
                <a href="service-detail.php?slug=<?= sanitize($r['slug']) ?>" class="card card-hover" style="text-decoration: none;">
                    <div style="font-size: 2rem; color: var(--color-accent); margin-bottom: var(--space-3);"><i class="fas <?= sanitize($r['icon']) ?>"></i></div>
                    <h4 style="font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--text-primary);"><?= sanitize($r['title']) ?></h4>
                    <p style="color: var(--text-secondary); font-size: var(--font-size-sm);"><?= sanitize($r['description']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>