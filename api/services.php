<?php
$pageTitle = 'Services';
require_once 'includes/header.php';

$services = getAllServices();
?>

<section class="services-hero">
    <div class="container">
        <span class="section-tag">/ Services</span>
        <h1>Enterprise-Grade <span class="highlight">Solutions</span></h1>
        <p>Three high-margin service lines designed to scale your business, not just your codebase.</p>
    </div>
</section>

<section class="services-detail">
    <div class="container">
        <?php foreach ($services as $svc): 
            $features = json_decode($svc['features'] ?? '[]', true);
        ?>
        <div class="service-detail-card" id="<?= sanitize($svc['slug']) ?>">
            <div class="service-detail-image">
                <i class="fas <?= sanitize($svc['icon']) ?>"></i>
            </div>
            <div class="service-detail-content">
                <h2><?= sanitize($svc['title']) ?></h2>
                <p><?= nl2br(sanitize($svc['description'])) ?></p>
                <ul class="feature-list">
                    <?php foreach ($features as $f): ?>
                    <li><i class="fas fa-check-circle"></i> <?= sanitize($f) ?></li>
                    <?php endforeach; ?>
                </ul>
                <div style="margin-bottom:20px; font-weight:600; color:var(--accent);">
                    Typical Range: <?= sanitize($svc['price_min']) ?>
                </div>
                <a href="contact.php?service=<?= sanitize($svc['slug']) ?>" class="btn btn-primary">Request Quote <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($services)): ?>
        <!-- Static fallback -->
        <div class="service-detail-card" id="custom-software-web">
           <div class="service-detail-image"><i class="fas fa-laptop-code fa-5x"></i></div>
            <div class="service-detail-content">
                <h2>Custom Software & Web Development</h2>
                <p>We architect and build scalable software products—from MVPs to enterprise platforms. Our stack covers React, Vue, Node.js, PHP/Laravel, Python, and cloud-native deployments.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> SaaS & Web Application Development</li>
                    <li><i class="fas fa-check-circle"></i> API Design & Integration (REST/GraphQL)</li>
                    <li><i class="fas fa-check-circle"></i> Legacy System Modernization</li>
                    <li><i class="fas fa-check-circle"></i> E-commerce & CMS Solutions</li>
                    <li><i class="fas fa-check-circle"></i> Cloud Deployment & DevOps CI/CD</li>
                </ul>
                <a href="contact.php" class="btn btn-primary">Request Quote <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="service-detail-card" id="data-engineering-analytics">
            <div class="service-detail-image"><i class="fas fa-database"></i></div>
            <div class="service-detail-content">
                <h2>Data Engineering & Analytics</h2>
                <p>We design data lakes, warehouses, and real-time pipelines. From ETL automation to executive BI dashboards, we ensure your data is clean, governed, and ready for AI.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Data Lake & Warehouse Architecture</li>
                    <li><i class="fas fa-check-circle"></i> ETL/ELT Pipeline Engineering</li>
                    <li><i class="fas fa-check-circle"></i> Business Intelligence & Dashboards</li>
                    <li><i class="fas fa-check-circle"></i> Predictive Analytics & Reporting</li>
                    <li><i class="fas fa-check-circle"></i> Data Governance & Security</li>
                </ul>
                <a href="contact.php" class="btn btn-primary">Request Quote <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="service-detail-card" id="ai-agent-development">
            <div class="service-detail-image"><i class="fas fa-robot"></i></div>
            <div class="service-detail-content">
                <h2>AI Agent Development</h2>
                <p>We build autonomous AI agents that integrate with your CRM, ERP, and internal tools to execute tasks—lead qualification, report generation, inventory management, and support.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Custom GPT & Conversational Agents</li>
                    <li><i class="fas fa-check-circle"></i> Autonomous Business Process Agents</li>
                    <li><i class="fas fa-check-circle"></i> AI Workflow Automation</li>
                    <li><i class="fas fa-check-circle"></i> RAG Systems & Vector DB Integration</li>
                    <li><i class="fas fa-check-circle"></i> AI Integration into CRM/ERP</li>
                </ul>
                <a href="contact.php" class="btn btn-primary">Request Quote <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>