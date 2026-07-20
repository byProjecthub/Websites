<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/functions.php';

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$siteTitle = getSetting('site_title', 'Vueports Solutions');
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle ?? 'Home') ?> | <?= sanitize($siteTitle) ?></title>
    <meta name="description" content="<?= sanitize($pageDescription ?? 'Professional IT solutions: Custom Software, Data Engineering, and AI Agent Development.') ?>">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Cookie Consent -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css">
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <script>
    window.addEventListener('load', function(){
        window.cookieconsent.initialise({
            palette: {
                popup: { background: "#18181b", text: "#ffffff" },
                button: { background: "#4f46e5", text: "#ffffff" }
            },
            theme: "classic",
            position: "bottom-right",
            type: "opt-in",
            content: {
                message: "We use cookies to analyze traffic and personalize your experience.",
                dismiss: "Decline",
                allow: "Accept All",
                link: "Privacy Policy",
                href: "legal/privacy.php"
            },
            onInitialise: function(status) {
                if (status === 'allow') enableAnalytics();
            },
            onStatusChange: function(status) {
                if (status === 'allow') enableAnalytics();
            }
        });
    });
    </script>
</head>
<body>

<nav class="navbar" id="navbar">
    <div class="container nav-container">
        <a href="index.php" class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 200" width="300" height="80">
                <defs>
                    <linearGradient id="vGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#6366f1;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                    </linearGradient>
                    <linearGradient id="accentGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#ec4899;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f43f5e;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <!-- Stylized V Mark — FLIPPED UPSIDE DOWN -->
                <g transform="rotate(180 65 65)">
                    <path d="M 60 10 L 110 130 L 130 130 L 70 0 L 50 0 L 0 130 L 20 130 Z" fill="url(#vGrad)"/>
                    <path d="M 70 35 L 95 95 L 105 95 L 75 20 Z" fill="url(#accentGrad)" opacity="0.9"/>
                    <circle cx="115" cy="145" r="8" fill="url(#accentGrad)"/>
                </g>
                <text x="170" y="95" font-family="Inter, -apple-system, BlinkMacSystemFont, sans-serif" font-size="72" font-weight="800" fill="#0f172a" letter-spacing="-2">Vueports</text>
                <text x="172" y="130" font-family="Inter, -apple-system, BlinkMacSystemFont, sans-serif" font-size="22" font-weight="500" fill="#64748b" letter-spacing="4">SOLUTIONS</text>
            </svg>
        </a>

        <ul class="nav-menu" id="navMenu">
            <li>
                <a href="index.php" class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>">Home</a>
            </li>
            <li>
                <a href="about.php" class="nav-link <?= $currentPage === 'about' ? 'active' : '' ?>">About</a>
            </li>
            <li>
                <a href="services.php" class="nav-link <?= in_array($currentPage, ['services', 'service-detail']) ? 'active' : '' ?>">Services</a>
            </li>

            <!-- Dropdown Menu -->
            <li class="dropdown">
                <a href="#" class="nav-link <?= in_array($currentPage, ['portfolio', 'consultation', 'booking', 'calculator']) ? 'active' : '' ?>">
                    Get Started <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="portfolio.php" class="nav-link <?= $currentPage === 'portfolio' ? 'active' : '' ?>">Portfolio</a>
                    </li> 
                    <li>
                        <a href="consultation.php" class="nav-link <?= $currentPage === 'consultation' ? 'active' : '' ?>">Consult</a>
                    </li>
                    <li>
                        <a href="booking.php" class="nav-link <?= $currentPage === 'booking' ? 'active' : '' ?>">Book</a>
                    </li> 
                    <li>
                        <a href="calculator.php" class="nav-link <?= $currentPage === 'calculator' ? 'active' : '' ?>">Calculator</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="contact.php" class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a>
            </li>
        </ul>

        <div class="nav-actions">
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                <i class="fas fa-moon"></i>
            </button>
            <a href="contact.php" class="btn btn-primary btn-sm">Hire Us</a>
            <button class="hamburger" id="hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>