<?php
// Uncomment the next two lines to see errors, then comment them back once fixed
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

declare(strict_types=1);
$pageTitle = 'About';
$pageDescription = 'About Vueports Solutions - Engineering Revenue, Not Just Code.';

require_once 'includes/header.php';
?>

<section class="services-hero" style="padding-top:140px;">
    <div class="container">
        <span class="section-tag">/ About Us</span>
        <h1>Engineering Revenue, Not Just <span class="highlight">Code</span></h1>
    </div>

    <div class="container">
                   
            <!-- Main Content -->
            <div>
                <!-- Featured Image -->
                <div style="border-radius:16px; overflow:hidden; margin-bottom:32px; background:var(--bg-secondary);">
                    <img src="<?= sanitize($project['image'] ?? 'assets/images/placeholder.svg') ?>" 
                         alt="<?= sanitize($project['title'] ?? 'Project') ?>" 
                         style="width:100%; height:auto; display:block;"
                         onerror="this.src='/images/vueports.png'">
                </div>
            </div>  
</section>

<section class="section">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:start;">
            <div>
                <p style="font-size:1.25rem; line-height:1.7; color:var(--text-secondary); margin-bottom:24px;">
                    Vueports Solutions is a specialized technology partner focused on three high-margin disciplines high quality architecture for large scales and robust projects: <strong>Custom Software Development</strong>, <strong>Data Engineering & Analytics</strong>, and <strong>AI Agent Development</strong>.
                </p>
                <p style="color:var(--text-secondary); line-height:1.7; margin-bottom:24px;">
                    Since 2020, we have delivered secure, scalable systems for municipalities, startups, and design agencies across South Africa. Our approach combines clean architecture, modern cloud infrastructure, and business-first thinking.
                </p>
                <div style="margin-top:32px;">
                    <h3 style="margin-bottom:16px; font-size:1.125rem;">Why Clients Choose Us</h3>
                    <ul style="list-style:none; display:flex; flex-direction:column; gap:12px;">
                        <li style="display:flex; gap:12px; color:var(--text-secondary);">
                            <i class="fas fa-check-circle" style="color:var(--color-accent); margin-top:3px;"></i>
                            <span><strong>Outcome-Based Delivery:</strong> We scope to business KPIs, not just technical specs.</span>
                        </li>
                        <li style="display:flex; gap:12px; color:var(--text-secondary);">
                            <i class="fas fa-check-circle" style="color:var(--color-accent); margin-top:3px;"></i>
                            <span><strong>Full-Stack Depth:</strong> From React frontends to Python data pipelines to LLM orchestration.</span>
                        </li>
                        <li style="display:flex; gap:12px; color:var(--text-secondary);">
                            <i class="fas fa-check-circle" style="color:var(--color-accent); margin-top:3px;"></i>
                            <span><strong>Security First:</strong> Secure-by-design architecture with compliance awareness.</span>
                        </li>
                        <li style="display:flex; gap:12px; color:var(--text-secondary);">
                            <i class="fas fa-check-circle" style="color:var(--color-accent); margin-top:3px;"></i>
                            <span><strong>Post-Launch Partnership:</strong> Managed services, monitoring, and continuous optimization.</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div style="display:flex; flex-direction:column; gap:20px;">
                <div class="card" style="border-left:4px solid var(--color-accent);">
                    <h3 style="margin-bottom:8px; color:var(--color-accent);">Mission</h3>
                    <p style="color:var(--text-secondary);">To transform businesses into data-driven, AI-augmented organizations through world-class software engineering.</p>
                </div>
                <div class="card" style="border-left:4px solid var(--color-primary-400);">
                    <h3 style="margin-bottom:8px; color:var(--color-primary-400);">Vision</h3>
                    <p style="color:var(--text-secondary);">Become the most trusted technology production partner for mid-market companies in South Africa and beyond.</p>
                </div>
                <div class="card">
                    <h3 style="margin-bottom:8px;">Values</h3>
                    <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:12px;">
                        <span class="skill-tag">Integrity</span>
                        <span class="skill-tag">Excellence</span>
                        <span class="skill-tag">Innovation</span>
                        <span class="skill-tag">Partnership</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:var(--bg-secondary);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">/ Tech Stack</span>
            <h2 class="section-title">Technologies We <span class="highlight">Master</span></h2>
        </div>
        <div class="skills-showcase">
            <div class="skill-category card-hover">
                <h3><i class="fas fa-code"></i> Software & Web</h3>
                <div class="skill-tags">
                    <span class="skill-tag">React / Next.js</span>
                    <span class="skill-tag">Vue.js</span>
                    <span class="skill-tag">Node.js</span>
                    <span class="skill-tag">PHP / Laravel</span>
                    <span class="skill-tag">Python / Django</span>
                    <span class="skill-tag">TypeScript</span>
                    <span class="skill-tag">Tailwind CSS</span>
                </div>
            </div>
            <div class="skill-category card-hover">
                <h3><i class="fas fa-database"></i> Data & Cloud</h3>
                <div class="skill-tags">
                    <span class="skill-tag">PostgreSQL</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">MongoDB</span>
                    <span class="skill-tag">Snowflake</span>
                    <span class="skill-tag">BigQuery</span>
                    <span class="skill-tag">AWS</span>
                    <span class="skill-tag">Docker / K8s</span>
                </div>
            </div>
            <div class="skill-category card-hover">
                <h3><i class="fas fa-robot"></i> AI & Automation</h3>
                <div class="skill-tags">
                    <span class="skill-tag">OpenAI API</span>
                    <span class="skill-tag">LangChain</span>
                    <span class="skill-tag">Vector DBs</span>
                    <span class="skill-tag">RAG Pipelines</span>
                    <span class="skill-tag">Zapier / Make</span>
                    <span class="skill-tag">TensorFlow</span>
                    <span class="skill-tag">Pandas / NumPy</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header center">
            <span class="section-tag">/ FAQ</span>
            <h2 class="section-title">Frequently Asked <span class="highlight">Questions</span></h2>
        </div>

        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is your typical project timeline?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Project timelines vary based on complexity. A simple landing page typically takes 1-2 weeks, while a full web application can take 4-8 weeks. I'll provide a detailed timeline during our initial consultation.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you offer maintenance services?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes! I offer monthly maintenance packages that include security updates, performance monitoring, content updates, and technical support. This ensures your website stays secure and up-to-date.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>What technologies do you specialize in?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>I specialize in modern web technologies including HTML5, CSS3, JavaScript (React, Vue, Node.js), PHP, Python, and various databases. I also work with CMS platforms like WordPress and Shopify.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>How do you handle project pricing?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>I offer both fixed-price and hourly billing options. After understanding your requirements, I'll provide a detailed quote. Payment is typically split into milestones: 50% upfront, 50% upon completion.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Can you work with existing codebases?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Absolutely! I regularly work with existing codebases, whether it's adding new features, refactoring legacy code, or modernizing older applications. I'll review your code first and provide recommendations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
