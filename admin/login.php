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
                
                session_regenerate_id(true);
                
                redirect('dashboard.php');
            }
        }
    }
}
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
    <div class="login-box">
        <h2><i class="fas fa-shield-alt"></i> Admin Portal</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error" style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:16px;">
                <strong>Error:</strong> <?= sanitize($error) ?>
                <?php if ($debug): ?>
                    <br><small style="opacity:0.8;"><?= sanitize($debug) ?></small>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" autocomplete="on">
            <div class="form-group">
                <label for="admin-username">Username</label>
                <input type="text" id="admin-username" name="username" autocomplete="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="admin-password">Password</label>
                <input type="password" id="admin-password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
        </form>
        
        <p style="text-align:center; margin-top:16px; font-size:0.875rem;">
            <a href="../index.php">← Back to Website</a>
        </p>
    </div>
</body>
</html>