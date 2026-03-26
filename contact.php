<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

$errors  = [];
$success = '';
$form    = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

if (isLoggedIn()) {
    $stmt = $conn->prepare('SELECT username, email FROM users WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $form['name']  = $row['username'] ?? '';
    $form['email'] = $row['email']    ?? '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name']    ?? '');
    $email   = sanitize($_POST['email']   ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    $form = compact('name', 'email', 'subject', 'message');

    if (empty($name))          $errors[] = 'Name is required.';
    if (!isValidEmail($email)) $errors[] = 'Valid email is required.';
    if (empty($subject))       $errors[] = 'Subject is required.';
    if (strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';

    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $email, $subject, $message);
        if ($stmt->execute()) {
            $success = 'Thank you, ' . htmlspecialchars($name) . '! Your message has been sent.';
            $form = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
        } else {
            $errors[] = 'Could not send message. Please try again.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact – WanderCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg wc-navbar sticky-top">
    <div class="container-fluid">
        <a class="wc-logo-wrap" href="index.php">
            <img src="images/logo.png" alt="WanderCraft" class="wc-nav-logo"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-1 py-2 py-lg-0">
                <li><a class="wc-nav-link" href="index.php">Home</a></li>
                <li><a class="wc-nav-link" href="plain.php">Plan Trip</a></li>
                <li><a class="wc-nav-link" href="destinations.php">Destinations</a></li>
                <li><a class="wc-nav-link" href="itinerary.php">Itinerary</a></li>
                <li><a class="wc-nav-link" href="hotels.php">Hotels</a></li>
                <li><a class="wc-nav-link active-page" href="contact.php">Contact</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a class="wc-nav-link" href="dashboard.php">👤 <?= htmlspecialchars(getUsername()) ?></a></li>
                    <li class="ms-2"><a class="wc-nav-cta" href="auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a class="wc-nav-link" href="auth/login.php">Login</a></li>
                    <li class="ms-2"><a class="wc-nav-cta" href="auth/register.php">Register ✈</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="wc-page-header">
    <div class="container">
        <div class="wc-eyebrow">✦ GET IN TOUCH</div>
        <h2 class="wc-page-title">Contact Us</h2>
        <p class="wc-page-sub">Have a question? We're here to help.</p>
    </div>
</div>

<div class="py-5" style="background:#f4f7fb;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4">
                <div class="wc-panel mb-3">
                    <div class="wc-panel-title">
                        <div class="wc-panel-icon">📞</div>
                        Contact Information
                    </div>
                    <div style="font-size:13px;color:#7a8fa6;line-height:2.2;">
                        <div>📱 +94 77 123 4567</div>
                        <div>📧 info@wandercraft.com</div>
                        <div>📸 @wanderCraft</div>
                        <div>👍 /wanderCraft</div>
                    </div>
                </div>
                <div class="wc-panel">
                    <div class="wc-panel-title">
                        <div class="wc-panel-icon">🕐</div>
                        Office Hours
                    </div>
                    <div style="font-size:13px;color:#7a8fa6;line-height:2.2;">
                        <div>Mon–Fri: 9:00 AM – 6:00 PM</div>
                        <div>Saturday: 9:00 AM – 1:00 PM</div>
                        <div>Sunday: Closed</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="wc-panel">
                    <div class="wc-panel-title">
                        <div class="wc-panel-icon">✉️</div>
                        Send Us a Message
                    </div>

                    <?php if (!empty($success)): ?>
                        <div style="background:#d4edda;color:#155724;padding:14px 18px;border-radius:10px;font-size:14px;margin-bottom:20px;">
                            ✅ <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div style="background:#f8d7da;color:#721c24;padding:14px 18px;border-radius:10px;font-size:13px;margin-bottom:20px;">
                            <?php foreach ($errors as $e): ?>
                                <div>⚠️ <?= htmlspecialchars($e) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="contact.php" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="wc-label">YOUR NAME</label>
                                <input type="text" name="name" class="wc-input" placeholder="Full name" required value="<?= htmlspecialchars($form['name']) ?>"/>
                            </div>
                            <div class="col-md-6">
                                <label class="wc-label">EMAIL ADDRESS</label>
                                <input type="email" name="email" class="wc-input" placeholder="your@email.com" required value="<?= htmlspecialchars($form['email']) ?>"/>
                            </div>
                            <div class="col-12">
                                <label class="wc-label">SUBJECT</label>
                                <input type="text" name="subject" class="wc-input" placeholder="What is your query about?" value="<?= htmlspecialchars($form['subject']) ?>"/>
                            </div>
                            <div class="col-12">
                                <label class="wc-label">MESSAGE</label>
                                <textarea name="message" class="wc-input" rows="5" placeholder="Tell us how we can help..." style="resize:vertical;"><?= htmlspecialchars($form['message']) ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="wc-btn-primary">Send Message ✉️</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="wc-footer">
    <div class="container">
        <div class="wc-footer-bottom">
            <div class="wc-footer-copy">© 2025 WanderCraft · All Rights Reserved</div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>