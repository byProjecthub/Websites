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
    
    <link rel="icon" type="image/png" href="/images/apple-touch-icon-black.png">
    
    <!-- MOBILE NAV FIXES -->
    <style>
        /* Overlay — MUST be above navbar */
        .nav-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .nav-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile menu — MUST be above overlay AND navbar */
        @media (max-width: 1023px) {
            .nav-menu {
                position: fixed;
                top: 0;
                right: -110%;
                width: 85%;
                max-width: 360px;
                height: 100vh;
                height: 100dvh;
                background: var(--bg-card, #ffffff);
                flex-direction: column;
                padding: 100px 28px 32px;
                transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -10px 0 40px rgba(0,0,0,0.2);
                gap: 0;
                overflow-y: auto;
                z-index: 2001; /* ABOVE overlay and navbar */
            }
            [data-theme="dark"] .nav-menu {
                background: var(--bg-primary, #0f172a);
            }
            .nav-menu.active {
                right: 0;
            }

            .nav-menu > li {
                width: 100%;
            }

            .nav-link {
                padding: 16px 0;
                border-bottom: 1px solid var(--border-color, #e2e8f0);
                width: 100%;
                font-size: 1.125rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .nav-link::after {
                display: none !important;
            }

            /* Dropdown */
            .dropdown {
                width: 100%;
            }
            .dropdown-toggle i {
                transition: transform 0.3s ease;
                font-size: 0.875rem;
                margin-left: auto;
            }
            .dropdown.active .dropdown-toggle i {
                transform: rotate(180deg);
            }

            .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                border: none;
                background: var(--bg-secondary, #f1f5f9);
                margin: 0 0 12px;
                padding: 8px 0;
                border-radius: 12px;
                display: none;
                min-width: 100%;
                overflow: hidden;
                animation: none;
            }
            [data-theme="dark"] .dropdown-menu {
                background: var(--bg-secondary, #1e293b);
            }
            .dropdown.active .dropdown-menu {
                display: block;
                animation: dropdownSlide 0.2s ease;
            }
            @keyframes dropdownSlide {
                from { opacity: 0; transform: translateY(-6px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .dropdown-menu a {
                padding: 12px 20px;
                border-bottom: 1px solid var(--border-color-light, rgba(0,0,0,0.05));
                font-size: 1rem;
                display: block;
            }
            .dropdown-menu a:last-child {
                border-bottom: none;
            }

            /* Hamburger — visible only on mobile */
            .hamburger {
                display: flex !important;
                position: relative;
                z-index: 2002; /* Above menu */
            }
            .hamburger span {
                transition: all 0.3s ease;
            }
            .hamburger.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            .hamburger.active span:nth-child(2) {
                opacity: 0;
                transform: scaleX(0);
            }
            .hamburger.active span:nth-child(3) {
                transform: rotate(-45deg) translate(5px, -5px);
            }

            /* Hide Hire Us button in top bar on mobile if you want cleaner look */
            .nav-actions .btn-primary {
                display: none;
            }
        }

        @media (min-width: 1024px) {
            .hamburger {
                display: none !important;
            }
            .nav-overlay {
                display: none !important;
            }
        }

        /* Lock body scroll */
        body.menu-open {
            overflow: hidden;
            touch-action: none;
        }
    </style>
    
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
            <li><a href="index.php" class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>">Home</a></li>
            <li><a href="about.php" class="nav-link <?= $currentPage === 'about' ? 'active' : '' ?>">About</a></li>
            <li><a href="services.php" class="nav-link <?= in_array($currentPage, ['services','service-detail']) ? 'active' : '' ?>">Services</a></li>

            <li class="dropdown" id="getStartedDropdown">
                <a href="#" class="nav-link dropdown-toggle <?= in_array($currentPage, ['portfolio','consultation','booking','calculator']) ? 'active' : '' ?>">
                    Get Started <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" id="getStartedMenu">
                    <li><a href="portfolio.php" class="nav-link <?= $currentPage === 'portfolio' ? 'active' : '' ?>">Portfolio</a></li>
                    <li><a href="consultation.php" class="nav-link <?= $currentPage === 'consultation' ? 'active' : '' ?>">Consult</a></li>
                    <li><a href="booking.php" class="nav-link <?= $currentPage === 'booking' ? 'active' : '' ?>">Book</a></li>
                    <li><a href="calculator.php" class="nav-link <?= $currentPage === 'calculator' ? 'active' : '' ?>">Calculator</a></li>
                </ul>
            </li>

            <li><a href="contact.php" class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a></li>
        </ul>

        <div class="nav-actions">
            <a href="contact.php" class="btn btn-primary btn-sm">Hire Us</a>
            <button class="hamburger" id="hamburger" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<div class="nav-overlay" id="navOverlay"></div>

<script>
(function() {
    const hamburger = document.getElementById('hamburger');
    const navMenu   = document.getElementById('navMenu');
    const overlay   = document.getElementById('navOverlay');
    const dropdowns = document.querySelectorAll('.dropdown');
    const body      = document.body;

    function isMobile() {
        return window.innerWidth <= 1023;
    }

    function openMenu() {
        hamburger.classList.add('active');
        hamburger.setAttribute('aria-expanded', 'true');
        navMenu.classList.add('active');
        overlay.classList.add('active');
        body.classList.add('menu-open');
    }

    function closeMenu() {
        hamburger.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        navMenu.classList.remove('active');
        overlay.classList.remove('active');
        body.classList.remove('menu-open');
        dropdowns.forEach(d => d.classList.remove('active'));
    }

    hamburger.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (navMenu.classList.contains('active')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener('click', closeMenu);

    // Close when clicking any link inside the menu (except dropdown toggle)
    navMenu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!isMobile()) return;
            
            // If this is a dropdown toggle, don't close — let dropdown handler manage it
            if (this.classList.contains('dropdown-toggle')) return;
            
            // If this link is inside a dropdown menu, close the whole menu
            if (this.closest('.dropdown-menu')) {
                closeMenu();
                return;
            }
            
            // Regular top-level link
            closeMenu();
        });
    });

    // Dropdown toggles
    dropdowns.forEach(function(dropdown) {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        if (!toggle) return;

        toggle.addEventListener('click', function(e) {
            if (!isMobile()) {
                e.preventDefault(); // prevent # jump on desktop too
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            const isOpen = dropdown.classList.contains('active');

            // Close siblings
            dropdowns.forEach(function(d) {
                if (d !== dropdown) d.classList.remove('active');
            });

            dropdown.classList.toggle('active', !isOpen);
        });
    });

    // Click outside any dropdown to close just the dropdown (keep menu open)
    document.addEventListener('click', function(e) {
        if (!isMobile()) return;
        if (!e.target.closest('.dropdown')) {
            dropdowns.forEach(d => d.classList.remove('active'));
        }
    });

    // Escape closes everything
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
    });

    // Reset on resize to desktop
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 1023) closeMenu();
        }, 150);
    });

    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });
    }
})();
</script>
