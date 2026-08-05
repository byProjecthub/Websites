# ============================================
# header.php — ROOT LEVEL (correct paths)
# ============================================
header_php = '''<?php
// Vueports Solutions — Header Template (Root Level)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($basePath)) { $basePath = './'; }

// Auth state
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userEmail = $_SESSION['user_email'] ?? '';
$userRole = $_SESSION['user_role'] ?? 'client';

// Flash messages
$flashMessage = $_SESSION['flash_message'] ?? null;
$flashType = $_SESSION['flash_type'] ?? 'info';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);

// Active page helper
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
function isActive($page, $current) {
    return $page === $current ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Vueports Solutions</title>
  <meta name="description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : 'Vueports Solutions — Custom Software, Data Engineering & AI Agents'; ?>">
  <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/variables.css">
  <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
</head>
<body>

<!-- Flash Message -->
<?php if ($flashMessage): ?>
<div id="flashMessage" class="alert alert-<?php echo htmlspecialchars($flashType); ?>" style="position: fixed; top: 90px; left: 50%; transform: translateX(-50%); z-index: 500; max-width: 500px; width: 90%; text-align: center; box-shadow: var(--shadow-lg);">
  <?php echo htmlspecialchars($flashMessage); ?>
</div>
<script>
setTimeout(() => {
  const el = document.getElementById('flashMessage');
  if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.5s'; setTimeout(() => el.remove(), 500); }
}, 4000);
</script>
<?php endif; ?>

<!-- Navigation -->
<nav class="navbar" id="navbar">
  <div class="navbar-inner">
    <a href="<?php echo $basePath; ?>index.php" class="navbar-logo">Vueports<span>.</span></a>

    <div class="navbar-links">
      <a href="<?php echo $basePath; ?>index.php" class="<?php echo isActive('index', $currentPage); ?>">Home</a>
      <a href="<?php echo $basePath; ?>about.php" class="<?php echo isActive('about', $currentPage); ?>">About</a>
      <a href="<?php echo $basePath; ?>services.php" class="<?php echo isActive('services', $currentPage); ?>">Services</a>
      <a href="<?php echo $basePath; ?>pricing.php" class="<?php echo isActive('pricing', $currentPage); ?>">Pricing</a>
      <a href="<?php echo $basePath; ?>contact.php" class="<?php echo isActive('contact', $currentPage); ?>">Contact</a>
      <?php if ($isLoggedIn): ?>
        <a href="<?php echo $basePath; ?>portal/dashboard.php" class="<?php echo isActive('dashboard', $currentPage); ?>">Portal</a>
      <?php endif; ?>
    </div>

    <div class="navbar-actions">
      <?php if ($isLoggedIn): ?>
        <span style="font-size: var(--text-sm); color: var(--text-secondary); display: inline-flex; align-items: center; gap: var(--space-2);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          <?php echo htmlspecialchars($userName ?: 'Account'); ?>
        </span>
        <a href="<?php echo $basePath; ?>logout.php" class="btn btn-secondary" style="display:inline-flex;">Sign Out</a>
      <?php else: ?>
        <a href="<?php echo $basePath; ?>login.php" class="btn btn-secondary" style="display:inline-flex;">Sign In</a>
        <a href="<?php echo $basePath; ?>consultation.php" class="btn btn-primary" style="display:inline-flex;">Get Started</a>
      <?php endif; ?>
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
  <a href="<?php echo $basePath; ?>about.php" onclick="toggleMobileNav()">About</a>
  <a href="<?php echo $basePath; ?>services.php" onclick="toggleMobileNav()">Services</a>
  <a href="<?php echo $basePath; ?>pricing.php" onclick="toggleMobileNav()">Pricing</a>
  <a href="<?php echo $basePath; ?>contact.php" onclick="toggleMobileNav()">Contact</a>
  <?php if ($isLoggedIn): ?>
    <a href="<?php echo $basePath; ?>portal/dashboard.php" onclick="toggleMobileNav()">Portal</a>
    <a href="<?php echo $basePath; ?>logout.php" onclick="toggleMobileNav()">Sign Out</a>
  <?php else: ?>
    <a href="<?php echo $basePath; ?>login.php" onclick="toggleMobileNav()">Sign In</a>
  <?php endif; ?>
</div>
