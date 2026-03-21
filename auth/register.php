<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit();
}
require_once '../includes/db.php';
require_once '../includes/functions.php';

$errors = [];
$formData = ['username' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email    = sanitize($_POST['email']    ?? '');
    $password =          $_POST['password'] ?? '';
    $confirm  =          $_POST['confirm']  ?? '';
    $formData = ['username' => $username, 'email' => $email];

    if (empty($username) || strlen($username) < 3)
        $errors[] = 'Username must be at least 3 characters.';
    if (!isValidEmail($email))
        $errors[] = 'Please enter a valid email address.';
    if (!isValidPassword($password))
        $errors[] = 'Password must be at least 8 characters with letters and numbers.';
    if ($password !== $confirm)
        $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0)
            $errors[] = 'Username or email already registered.';
        $stmt->close();
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $username, $email, $hashed);
        if ($stmt->execute()) {
            $stmt->close();
            redirectWithMessage('../auth/login.php', 'success', 'Account created! Please log in.');
        } else {
            $errors[] = 'Registration failed. Please try again.';
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register – WanderCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../style.css"/>
    <style>
        .auth-wrap { min-height:100vh; display:flex; align-items:center; background:linear-gradient(135deg,#0a1628,#0d2a4a); }
        .auth-card { background:#fff; border-radius:20px; padding:40px 36px; max-width:460px; width:100%; margin:0 auto; box-shadow:0 20px 60px rgba(0,0,0,.35); }
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
            <h2 class="auth-title">Create Account</h2>
            <p class="auth-sub">Join WanderCraft and start planning your Sri Lanka journey</p>

            <?php if (!empty($errors)): ?>
                <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;">
                    <?php foreach ($errors as $e): ?>
                        <div>⚠️ <?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" novalidate>
                <div class="mb-3">
                    <label class="wc-label">USERNAME</label>
                    <input type="text" name="username" class="wc-input" placeholder="Choose a username" required value="<?= htmlspecialchars($formData['username']) ?>"/>
                </div>
                <div class="mb-3">
                    <label class="wc-label">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="wc-input" placeholder="your@email.com" required value="<?= htmlspecialchars($formData['email']) ?>"/>
                </div>
                <div class="mb-3">
                    <label class="wc-label">PASSWORD</label>
                    <input type="password" name="password" class="wc-input" placeholder="Min 8 chars, letters + numbers" required/>
                </div>
                <div class="mb-4">
                    <label class="wc-label">CONFIRM PASSWORD</label>
                    <input type="password" name="confirm" id="confirm" class="wc-input" placeholder="Repeat your password" required/>
                    <div class="wc-err d-none" id="confirm-err">⚠ Passwords do not match</div>
                </div>
                <button type="submit" class="wc-btn-primary w-100">Create Account ✈</button>
            </form>
            <div class="auth-link">Already have an account? <a href="login.php">Sign In</a></div>
        </div>
    </div>
</div>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    var pass = document.querySelector('[name="password"]').value;
    var confirm = document.getElementById('confirm').value;
    var errEl = document.getElementById('confirm-err');
    if (pass !== confirm) {
        e.preventDefault();
        errEl.classList.remove('d-none');
    } else {
        errEl.classList.add('d-none');
    }
});
</script>
</body>
</html>