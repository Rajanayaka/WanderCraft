<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit();
}
require_once '../includes/db.php';
require_once '../includes/functions.php';

$error = '';
$formData = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = sanitize($_POST['email']    ?? '');
    $password =          $_POST['password'] ?? '';
    $formData = ['email' => $email];

    if (empty($email) || empty($password)) {
        $error = 'Please enter your email and password.';
    } elseif (!isValidEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $stmt->close();
                redirectWithMessage('../dashboard.php', 'success', 'Welcome back, ' . $user['username'] . '!');
            } else {
                $error = 'Incorrect password.';
            }
        } else {
            $error = 'No account found with that email.';
        }
        $stmt->close();
    }
}

$loggedOut = isset($_GET['msg']) && $_GET['msg'] === 'logged_out';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login – WanderCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../style.css"/>
    <style>
        .auth-wrap { min-height:100vh; display:flex; align-items:center; background:linear-gradient(135deg,#0a1628,#0d2a4a); }
        .auth-card { background:#fff; border-radius:20px; padding:40px 36px; max-width:440px; width:100%; margin:0 auto; box-shadow:0 20px 60px rgba(0,0,0,.35); }
        .auth-logo { font-family:'Playfair Display',serif; font-size:26px; color:#0a1628; font-weight:700; text-decoration:none; }
        .auth-logo span { color:#00aed6; }
        .auth-title { font-family:'Playfair Display',serif; font-size:22px; color:#0d1f3c; margin:18px 0 6px; }
        .auth-sub { font-size:13px; color:#7a8fa6; margin-bottom:24px; }
        .auth-link { font-size:13px; color:#7a8fa6; text-align:center; margin-top:18px; }
        .auth-link a { color:#00aed6; font-weight:700; text-decoration:none; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="container">
        <div class="auth-card">
            <a class="auth-logo" href="../index.php">Wander<span>Craft</span></a>
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-sub">Sign in to continue planning your Sri Lanka adventure</p>

            <?php if ($loggedOut): ?>
                <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                    ✅ Successfully logged out!
                </div>
            <?php endif; ?>

            <?= showFlashMessage() ?>

            <?php if (!empty($error)): ?>
                <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                    ⚠️ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" novalidate>
                <div class="mb-3">
                    <label class="wc-label">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="wc-input" placeholder="your@email.com" required value="<?= htmlspecialchars($formData['email']) ?>"/>
                </div>
                <div class="mb-4">
                    <label class="wc-label">PASSWORD</label>
                    <input type="password" name="password" class="wc-input" placeholder="Your password" required/>
                </div>
                <button type="submit" class="wc-btn-primary w-100">Sign In →</button>
            </form>
            <div class="auth-link">Don't have an account? <a href="register.php">Register here</a></div>
            <div class="auth-link mt-2"><a href="../index.php" style="color:#7a8fa6;">← Back to Home</a></div>
        </div>
    </div>
</div>
</body>
</html>