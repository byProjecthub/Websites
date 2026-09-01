<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

// TEMPORARY: Clear stuck session
if (isset($_GET['logout'])) {
    session_destroy();
    redirect('login.php');
}
// CRITICAL: Start session before ANY auth check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Show current session state (remove this line once fixed)
// var_dump($_SESSION);

if (isAdmin()) {
    redirect('dashboard.php');
}

$error = '';
$debug = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    
    if (empty($username) || empty($pass)) {
        $error = 'Please enter both username and password.';
    } else {
        $db = db();
        
        if (!$db) {
            $error = 'Database connection failed. Check your database config.';
        } else {
            // Try to find the user
            $stmt = $db->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $row = $stmt->fetch();
            
            if (!$row) {
                $error = 'User not found in database.';
            } elseif (!password_verify($pass, $row['password'])) {
                $error = 'Password does not match. Make sure you created the user with password_hash().';
                $debug = 'Stored hash starts with: ' . substr($row['password'], 0, 10) . '...';
            } else {
                // SUCCESS
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'] ?? 'admin';
                $_SESSION['admin_role'] = $row['role'] ?? 'admin';


                 $stmt = $db->prepare("UPDATE admins SET last_login_at = NOW(), last_login_ip = ? WHERE id = ?");
                        $stmt->execute([$_SERVER['REMOTE_ADDR'] ?? null, $user['id']]);
                
                session_regenerate_id(true);

                
                redirect('dashboard.php');
            }
        }
    }
}
$pageTitle = 'Sign-In';
require_once 'includes/header.php'>;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Vueports Solutions</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-login">
    <div class="auth-page">
  <div class="auth-card reveal">
    <div class="auth-logo">Vueports<span>.</span></div>
    <p class="auth-subtitle">Sign in to your Admin portal</p>
        
       <?php if ($success): ?>
      <div class="alert alert-success" style="margin-bottom: var(--space-6);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="display:inline; vertical-align:text-bottom; margin-right:var(--space-2);"><polyline points="20 6 9 17 4 12"></polyline></svg>
        <?php echo htmlspecialchars($success); ?>
      </div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-error" style="margin-bottom: var(--space-6);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="display:inline; vertical-align:text-bottom; margin-right:var(--space-2);"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
        <form action="" method="POST" autocomplete="on">
      <input type="hidden" name="csrf_token" value="<?php echo csrfToken(); ?>">

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-input" placeholder="you@company.com" autocomplete="username" required autofocus>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="••••••••" autocomplete="current-password" required>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <label style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm); color: var(--text-secondary); cursor: pointer;">
          <input type="checkbox" name="remember" style="width: 16px; height: 16px;">
          Remember me
        </label>
        <a href="forgot-password.php" style="font-size: var(--text-sm); color: var(--accent-indigo); font-weight: 500;">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
        Sign In
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </button>
    </form>
       <div class="auth-divider"><span>or</span></div>
        
        <p style="text-align:center; margin-top:16px; font-size:0.875rem;">
            <a href="../index.php">← Back to Website</a>
        </p
           <p class="auth-footer">
      Don't have an account? <a href="register.php">Create one</a>
    </p>  
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
