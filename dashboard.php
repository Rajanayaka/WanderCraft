<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';
requireLogin();

$userId   = $_SESSION['user_id'];
$username = $_SESSION['username'];

$stmt = $conn->prepare('SELECT email, created_at FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$userInfo = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare('SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC LIMIT 5');
$stmt->bind_param('i', $userId);
$stmt->execute();
$bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard – WanderCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .dash-avatar { width:70px; height:70px; border-radius:50%; background:linear-gradient(135deg,#00aed6,#0a1628); display:flex; align-items:center; justify-content:center; font-size:28px; color:#fff; font-weight:800; flex-shrink:0; }
        .dash-stat { background:linear-gradient(135deg,#0a1628,#0d2a4a); border-radius:16px; padding:22px 20px; text-align:center; border:1px solid rgba(0,212,255,.14); }
        .dash-stat-num { font-size:32px; color:#00d4ff; font-weight:800; font-family:'Playfair Display',serif; }
        .dash-stat-lbl { font-size:11px; color:#b0c4d8; letter-spacing:2px; margin-top:4px; }
    </style>
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
                <li><a class="wc-nav-link" href="contact.php">Contact</a></li>
                <li><a class="wc-nav-link active-page" href="dashboard.php">Dashboard</a></li>
                <li class="ms-2"><a class="wc-nav-cta" href="auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="wc-page-header">
    <div class="container">
        <div class="wc-eyebrow">✦ MY ACCOUNT</div>
        <h2 class="wc-page-title">Welcome, <?= htmlspecialchars($username) ?> 👋</h2>
        <p class="wc-page-sub">Manage your bookings and account details</p>
    </div>
</div>

<div class="py-4" style="background:#f4f7fb;">
    <div class="container">

        <?= showFlashMessage() ?>

        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="wc-panel h-100">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="dash-avatar"><?= strtoupper(substr($username, 0, 1)) ?></div>
                        <div>
                            <div style="font-size:18px;font-weight:800;color:#0d1f3c;"><?= htmlspecialchars($username) ?></div>
                            <div style="font-size:13px;color:#7a8fa6;"><?= htmlspecialchars($userInfo['email']) ?></div>
                            <div style="font-size:11px;color:#b0c4d8;margin-top:4px;">Member since <?= date('M Y', strtotime($userInfo['created_at'])) ?></div>
                        </div>
                    </div>
                    <a href="plain.php" class="wc-btn-primary d-block text-center text-decoration-none">✈ Plan a New Trip</a>
                    <a href="contact.php" class="wc-btn-outline d-block text-center text-decoration-none mt-2">Contact Us</a>
                    <div class="mt-3 text-center">
                        <a href="auth/logout.php" style="font-size:13px;color:#ff6b35;font-weight:700;text-decoration:none;">Sign Out →</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row g-3 mb-3">
                    <div class="col-6 col-md-4">
                        <div class="dash-stat">
                            <div class="dash-stat-num"><?= count($bookings) ?></div>
                            <div class="dash-stat-lbl">BOOKINGS</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="dash-stat">
                            <div class="dash-stat-num">🌴</div>
                            <div class="dash-stat-lbl">EXPLORE SRI LANKA</div>
                        </div>
                    </div>
                </div>

                <div class="wc-panel">
                    <div class="wc-side-label mb-3">QUICK LINKS</div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="destinations.php" class="wc-pill">🗺️ Destinations</a>
                        <a href="itinerary.php"    class="wc-pill">📅 Itinerary</a>
                        <a href="hotels.php"       class="wc-pill">🏨 Hotels</a>
                        <a href="contact.php"       class="wc-pill">✉️ Contact</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="wc-panel">
            <div class="wc-panel-title">
                <div class="wc-panel-icon">🏨</div>
                My Bookings
            </div>
            <?php if (empty($bookings)): ?>
                <p style="color:#7a8fa6;font-size:14px;">No bookings yet. <a href="hotels.php" style="color:#00aed6;font-weight:700;">Browse hotels →</a></p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="font-size:11px;color:#b0c4d8;letter-spacing:1.5px;">
                                <th>HOTEL</th>
                                <th>DESTINATION</th>
                                <th>CHECK-IN</th>
                                <th>NIGHTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $b): ?>
                            <tr style="font-size:13px;">
                                <td><strong><?= htmlspecialchars($b['hotel_name']) ?></strong></td>
                                <td><?= htmlspecialchars($b['destination']) ?></td>
                                <td><?= date('d M Y', strtotime($b['checkin_date'])) ?></td>
                                <td><?= $b['nights'] ?> nights</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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