<?php
$basePath = '../';
$pageTitle = 'Sign In';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In | Vueports Solutions</title>
  <link rel="stylesheet" href="../assets/css/variables.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="auth-page">
  <div class="auth-card animate-scale-in">
    <div class="auth-logo">Vueports<span>.</span></div>
    <p class="auth-subtitle">Sign in to your client portal</p>

    <form action="" method="POST">
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" class="form-input" placeholder="you@company.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" class="form-input" placeholder="••••••••" required>
      </div>

      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6);">
        <label style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm); color: var(--text-secondary); cursor: pointer;">
          <input type="checkbox" style="width: 16px; height: 16px; accent-color: var(--accent-indigo);">
          Remember me
        </label>
        <a href="#" style="font-size: var(--text-sm); color: var(--accent-indigo);">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
        Sign In
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </button>
    </form>

    <div class="auth-divider"><span>or</span></div>

    <button class="btn btn-secondary" style="width: 100%; margin-bottom: var(--space-3);">
      <svg width="18" height="18" viewBox="0 0 24 24" style="margin-right: var(--space-2);"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
      Continue with Google
    </button>

    <p class="auth-footer">
      Don't have an account? <a href="register.php">Create one</a>
    </p>
  </div>
</div>

</body>
</html>
