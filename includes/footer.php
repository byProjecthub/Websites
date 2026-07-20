<?php
$email = getSetting('contact_email', 'njabulod.hlongwane@gmail.com');
$phone = getSetting('contact_phone', '+27 (68) 826-1507');
$location = getSetting('location', 'Johannesburg, SA');
$siteTitle = getSetting('site_title', 'Vueports Solutions');
?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="index.php" class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 200" width="200" height="50">
                        <defs>
                            <linearGradient id="vGradF" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="accentGradF" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#ec4899;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#f43f5e;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <!-- Stylized V Mark — FLIPPED UPSIDE DOWN -->
                        <g transform="rotate(180, 65, 65)">
                            <path d="M 60 10 L 110 130 L 130 130 L 70 0 L 50 0 L 0 130 L 20 130 Z" fill="url(#vGradF)"/>
                            <path d="M 70 35 L 95 95 L 105 95 L 75 20 Z" fill="url(#accentGradF)" opacity="0.9"/>
                            <circle cx="115" cy="145" r="8" fill="url(#accentGradF)"/>
                        </g>
                        <text x="170" y="95" font-family="Inter, -apple-system, BlinkMacSystemFont, sans-serif" font-size="72" font-weight="800" fill="#0f172a" letter-spacing="-2">Vueports</text>
                        <text x="172" y="130" font-family="Inter, -apple-system, BlinkMacSystemFont, sans-serif" font-size="22" font-weight="500" fill="#64748b" letter-spacing="4">SOLUTIONS</text>
                    </svg>
                </a>
                <p>Building digital experiences that matter. We specialize in custom software, data engineering, and AI agent development.</p>
                <div class="social-links">
                    <a href="https://github.com/byprojecthub" class="social-link" aria-label="GitHub" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    <a href="https://www.linkedin.com/in/njabulo-dlamini-58b66a268/" class="social-link" aria-label="LinkedIn" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://x.com/Colourerr" class="social-link" aria-label="Twitter" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Services</h4>
                <ul>
                    <li><a href="service-detail.php?slug=custom-software-web">Custom Software & Web</a></li>
                    <li><a href="service-detail.php?slug=data-engineering-analytics">Data Engineering</a></li>
                    <li><a href="service-detail.php?slug=ai-agent-development">AI Agent Development</a></li>
                    <li><a href="services.php">View All Services</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Company</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="portfolio.php">Portfolio</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Contact</h4>
                <p><i class="fas fa-envelope"></i> <a href="mailto:<?= sanitize($email) ?>"><?= sanitize($email) ?></a></p>
                <p><i class="fas fa-phone"></i> <a href="tel:<?= sanitize(preg_replace('/\D/', '', $phone)) ?>"><?= sanitize($phone) ?></a></p>
                <p><i class="fas fa-map-marker-alt"></i> <?= sanitize($location) ?></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= sanitize($siteTitle) ?>. All rights reserved.</p>
            <div class="footer-legal">
                <a href="legal/privacy.php">Privacy Policy</a>
                <a href="legal/terms.php">Terms of Service</a>
                <a href="legal/cookies.php">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<div class="toast" id="toast"></div>
<button id="backToTop" class="back-to-top" aria-label="Back to top" style="display:none;">
    <i class="fas fa-arrow-up"></i>
</button>

<script src="assets/js/main.js"></script>
</body>
</html>