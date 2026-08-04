<?php
$pageTitle = 'Create Account';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account | Vueports Solutions</title>
  <link rel="stylesheet" href="../assets/css/variables.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="auth-page">
  <div class="auth-card animate-scale-in">
    <div class="auth-logo">Vueports<span>.</span></div>
    <p class="auth-subtitle">Create your client portal account</p>

    <form action="" method="POST">
      <div class="grid-2" style="gap: var(--space-4);">
        <div class="form-group">
          <label class="form-label">First Name</label>
          <input type="text" class="form-input" placeholder="John" required>
        </div>
        <div class="form-group">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-input" placeholder="Doe" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" class="form-input" placeholder="you@company.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Company</label>
        <input type="text" class="form-input" placeholder="Your company name">
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" class="form-input" placeholder="Min 8 characters" required>
      </div>

      <div class="form-group">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-input" placeholder="••••••••" required>
      </div>

      <div style="margin-bottom: var(--space-6);">
        <label style="display: flex; align-items: flex-start; gap: var(--space-2); font-size: var(--text-sm); color: var(--text-secondary); cursor: pointer;">
          <input type="checkbox" style="width: 16px; height: 16px; margin-top: 2px; accent-color: var(--accent-indigo);" required>
          <span>I agree to the <a href="#" style="color: var(--accent-indigo);">Terms of Service</a> and <a href="#" style="color: var(--accent-indigo);">Privacy Policy</a></span>
        </label>
      </div>

      <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
        Create Account
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </button>
    </form>

    <p class="auth-footer">
      Already have an account? <a href="login.php">Sign in</a>
    </p>
  </div>
</div>

</body>
</html>
