<?php
// Vueports Solutions — Header Template
// Include config.php BEFORE this file to set BASE_PATH
if (!isset($basePath)) { $basePath = './'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' : ''; ?>Vueports Solutions</title>
  <meta name="description" content="Vueports Solutions — Custom Software, Data Engineering & AI Agents">
  <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/variables.css">
  <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
</head>
<body>

<!-- Navigation -->
<nav class="navbar">
  <div class="navbar-inner">
    <a href="<?php echo $basePath; ?>index.php" class="navbar-logo">Vueports<span>.</span></a>

    <div class="navbar-links">
      <a href="<?php echo $basePath; ?>index.php">Home</a>
      <a href="<?php echo $basePath; ?>pages/about.php">About</a>
      <a href="<?php echo $basePath; ?>pages/services.php">Services</a>
      <a href="<?php echo $basePath; ?>pages/pricing.php">Pricing</a>
      <a href="<?php echo $basePath; ?>pages/contact.php">Contact</a>
    </div>

    <div class="navbar-actions">
      <a href="<?php echo $basePath; ?>pages/login.php" class="btn btn-secondary" style="display:inline-flex;">Sign In</a>
      <a href="<?php echo $basePath; ?>pages/consultation.php" class="btn btn-primary" style="display:inline-flex;">Get Started</a>
      <button class="navbar-toggle" onclick="toggleMobileNav()" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </div>
</nav>

<!-- Mobile Nav Overlay -->
<div class="mobile-nav" id="mobileNav">
  <button class="mobile-nav-close" onclick="toggleMobileNav()" aria-label="Close">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
  </button>
  <a href="<?php echo $basePath; ?>index.php" onclick="toggleMobileNav()">Home</a>
  <a href="<?php echo $basePath; ?>pages/about.php" onclick="toggleMobileNav()">About</a>
  <a href="<?php echo $basePath; ?>pages/services.php" onclick="toggleMobileNav()">Services</a>
  <a href="<?php echo $basePath; ?>pages/pricing.php" onclick="toggleMobileNav()">Pricing</a>
  <a href="<?php echo $basePath; ?>pages/contact.php" onclick="toggleMobileNav()">Contact</a>
  <a href="<?php echo $basePath; ?>pages/login.php" onclick="toggleMobileNav()">Sign In</a>
</div>
