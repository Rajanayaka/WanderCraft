<?php
session_start();
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanderCraft</title>
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
                <li><a class="wc-nav-link active-page" href="index.php">Home</a></li>
                <li><a class="wc-nav-link" href="plain.html">Plan Trip</a></li>
                <li><a class="wc-nav-link" href="destinations.html">Destinations</a></li>
                <li><a class="wc-nav-link" href="itinerary.html">Itinerary</a></li>
                <li><a class="wc-nav-link" href="hotels.html">Hotels</a></li>
                <li><a class="wc-nav-link" href="contact.php">Contact</a></li>
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

<section class="wc-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <?php if (isLoggedIn()): ?>
                    <div class="wc-eyebrow mb-3">✦ WELCOME BACK, <?= strtoupper(htmlspecialchars(getUsername())) ?>!</div>
                <?php else: ?>
                    <div class="wc-eyebrow mb-3">✦ SMART TRAVEL PLANNER</div>
                <?php endif; ?>
                <h1 class="wc-hero-title">Craft Your<br/><em>Perfect</em> Journey<br/>Through Sri Lanka</h1>
                <p class="wc-hero-sub mt-3 mb-4">Time-smart itinerary planning, expert place recommendations and hotel booking — all in one beautiful platform.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="plain.html" class="wc-btn-primary">Start Planning ✈</a>
                    <a href="destinations.html" class="wc-btn-outline">Explore Destinations</a>
                </div>
                <?php if (!isLoggedIn()): ?>
                <div class="mt-3">
                    <a href="auth/register.php" style="font-size:13px;color:rgba(255,255,255,.5);text-decoration:none;">
                        New here? <span style="color:#00d4ff;font-weight:700;">Create a free account →</span>
                    </a>
                </div>
                <?php endif; ?>
                <div class="wc-stats-row mt-5 pt-3">
                    <div><div class="wc-stat-num">50+</div><div class="wc-stat-lbl">DESTINATIONS</div></div>
                    <div class="wc-stat-sep"></div>
                    <div><div class="wc-stat-num">8h</div><div class="wc-stat-lbl">SMART DAILY LIMIT</div></div>
                    <div class="wc-stat-sep"></div>
                    <div><div class="wc-stat-num">100+</div><div class="wc-stat-lbl">HAPPY TRAVELERS</div></div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="wc-dark-card mb-3">
                    <div class="wc-dark-card-label">✦ FEATURED DESTINATIONS</div>
                    <div class="wc-slider-wrap">
                        <div class="wc-slider-track" id="slider-track">
                            <div class="wc-slide"><img src="images/kandy.png" alt="Kandy" class="wc-slide-img"/><div class="wc-slide-overlay"></div><div class="wc-slide-label">Kandy</div></div>
                            <div class="wc-slide"><img src="images/ella.png" alt="Ella" class="wc-slide-img"/><div class="wc-slide-overlay"></div><div class="wc-slide-label">Ella</div></div>
                            <div class="wc-slide"><img src="images/sigiriya.png" alt="Sigiriya" class="wc-slide-img"/><div class="wc-slide-overlay"></div><div class="wc-slide-label">Sigiriya</div></div>
                            <div class="wc-slide"><img src="images/mirissa.png" alt="Mirissa" class="wc-slide-img"/><div class="wc-slide-overlay"></div><div class="wc-slide-label">Mirissa</div></div>
                            <div class="wc-slide"><img src="images/nuwara-eliya.png" alt="Nuwara Eliya" class="wc-slide-img"/><div class="wc-slide-overlay"></div><div class="wc-slide-label">Nuwara Eliya</div></div>
                        </div>
                        <button class="wc-slider-btn wc-slider-prev" onclick="prevSlide()">&#8249;</button>
                        <button class="wc-slider-btn wc-slider-next" onclick="nextSlide()">&#8250;</button>
                    </div>
                    <div class="wc-slider-dots mt-2">
                        <button class="wc-dot active-dot-s" onclick="goSlide(0)"></button>
                        <button class="wc-dot" onclick="goSlide(1)"></button>
                        <button class="wc-dot" onclick="goSlide(2)"></button>
                        <button class="wc-dot" onclick="goSlide(3)"></button>
                        <button class="wc-dot" onclick="goSlide(4)"></button>
                    </div>
                </div>
                <div class="wc-dark-card">
                    <div class="wc-dark-card-label">✦ TRIP PROGRESS</div>
                    <div class="wc-progress-row">
                        <span class="wc-prog-lbl">Planning</span>
                        <div class="progress flex-grow-1 wc-progress-bar-wrap"><div class="progress-bar wc-progress-fill" data-width="80%" style="width:0%"></div></div>
                        <span class="wc-prog-val">80%</span>
                    </div>
                    <div class="wc-progress-row mt-2">
                        <span class="wc-prog-lbl">Hotels</span>
                        <div class="progress flex-grow-1 wc-progress-bar-wrap"><div class="progress-bar wc-progress-fill" data-width="60%" style="width:0%"></div></div>
                        <span class="wc-prog-val">60%</span>
                    </div>
                    <div class="wc-progress-row mt-2">
                        <span class="wc-prog-lbl">Activities</span>
                        <div class="progress flex-grow-1 wc-progress-bar-wrap"><div class="progress-bar wc-progress-fill" data-width="45%" style="width:0%"></div></div>
                        <span class="wc-prog-val">45%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="wc-section-tag">✦ WHY WANDERCRAFT</div>
            <h2 class="wc-section-title mt-2">Plan Smarter, Travel Better</h2>
            <p class="wc-section-sub">Everything you need to craft the perfect Sri Lankan adventure</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4"><div class="wc-feat-card h-100"><div class="wc-feat-icon">🧭</div><h5 class="wc-feat-title">Smart Recommendations</h5><p class="wc-feat-desc">Destination-specific place suggestions tailored to your trip duration.</p></div></div>
            <div class="col-md-4"><div class="wc-feat-card h-100"><div class="wc-feat-icon">⏱️</div><h5 class="wc-feat-title">Time-Smart Scheduling</h5><p class="wc-feat-desc">Auto-schedule with 8h daily limits. Instant alert when you over-plan.</p></div></div>
            <div class="col-md-4"><div class="wc-feat-card h-100"><div class="wc-feat-icon">🏨</div><h5 class="wc-feat-title">Hotel Booking</h5><p class="wc-feat-desc">Browse budget, standard and luxury hotels near your destination.</p></div></div>
            <div class="col-md-4"><div class="wc-feat-card h-100"><div class="wc-feat-icon">🔒</div><h5 class="wc-feat-title">User Accounts</h5><p class="wc-feat-desc">Create a free account to save trips and manage your bookings.</p></div></div>
            <div class="col-md-4"><div class="wc-feat-card h-100"><div class="wc-feat-icon">🗓️</div><h5 class="wc-feat-title">Day-by-Day Itinerary</h5><p class="wc-feat-desc">Visual timeline showing exactly where you'll be every hour.</p></div></div>
            <div class="col-md-4"><div class="wc-feat-card h-100"><div class="wc-feat-icon">📱</div><h5 class="wc-feat-title">Fully Responsive</h5><p class="wc-feat-desc">Plan from desktop, tablet or mobile seamlessly.</p></div></div>
        </div>
    </div>
</section>

<section class="wc-dest-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="wc-section-tag-light">✦ TOP DESTINATIONS</div>
            <h2 class="wc-section-title text-white mt-2">Explore Sri Lanka</h2>
            <p class="wc-dest-section-sub">Click on any destination to discover places you can visit</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="wc-dest-card" onclick="openDestModal('kandy')">
                    <img src="images/kandy.png" alt="Kandy" class="wc-dest-bg-img"/>
                    <div class="wc-dest-card-overlay"></div>
                    <div class="wc-dest-card-info">
                        <h4>Kandy</h4>
                        <div class="wc-dest-card-tag">✦ CULTURAL · HERITAGE</div>
                        <div class="d-flex gap-2 mt-2"><span class="wc-mini-badge">8 Places</span><span class="wc-mini-badge">2–3 Days</span></div>
                        <div class="wc-dest-click-hint mt-2">Click to explore →</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wc-dest-card" onclick="openDestModal('ella')">
                    <img src="images/ella.png" alt="Ella" class="wc-dest-bg-img"/>
                    <div class="wc-dest-card-overlay"></div>
                    <div class="wc-dest-card-info">
                        <h4>Ella</h4>
                        <div class="wc-dest-card-tag">✦ NATURE · ADVENTURE</div>
                        <div class="d-flex gap-2 mt-2"><span class="wc-mini-badge">6 Places</span><span class="wc-mini-badge">1–2 Days</span></div>
                        <div class="wc-dest-click-hint mt-2">Click to explore →</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wc-dest-card" onclick="openDestModal('sigiriya')">
                    <img src="images/sigiriya.png" alt="Sigiriya" class="wc-dest-bg-img"/>
                    <div class="wc-dest-card-overlay"></div>
                    <div class="wc-dest-card-info">
                        <h4>Sigiriya</h4>
                        <div class="wc-dest-card-tag">✦ HERITAGE · HISTORY</div>
                        <div class="d-flex gap-2 mt-2"><span class="wc-mini-badge">5 Places</span><span class="wc-mini-badge">1–2 Days</span></div>
                        <div class="wc-dest-click-hint mt-2">Click to explore →</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="plain.html" class="wc-btn-primary">Start Planning Your Trip →</a>
        </div>
    </div>
</section>

<div class="modal fade" id="destModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content wc-dest-modal">
            <div class="wc-dest-modal-hero" id="dest-modal-hero">
                <img id="dest-modal-hero-img" src="" alt="Destination"/>
                <div class="wc-dest-modal-overlay"></div>
                <div class="wc-dest-modal-hero-info">
                    <div class="wc-eyebrow mb-2" id="dest-modal-tag"></div>
                    <h3 class="wc-dest-modal-title" id="dest-modal-name"></h3>
                    <div class="d-flex flex-wrap gap-2 mt-2" id="dest-modal-badges"></div>
                </div>
                <button class="wc-dest-modal-close" onclick="closeDestModal()">✕</button>
            </div>
            <div class="modal-body p-4">
                <p class="wc-dest-modal-intro" id="dest-modal-intro"></p>
                <div class="d-flex flex-wrap gap-2 mb-4" id="dest-modal-chips"></div>
                <div class="wc-dest-modal-sub-title">📍 Places to Visit</div>
                <div class="row g-3 mt-1" id="dest-modal-places"></div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <a href="plain.html" class="wc-btn-primary w-100 text-center text-decoration-none">
                    Plan a Trip to <span id="dest-modal-plan-name"></span> →
                </a>
            </div>
        </div>
    </div>
</div>

<footer class="wc-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="wc-footer-brand">Wander<span>Craft</span></div>
                <div class="wc-footer-tag">SMART TRAVEL PLANNER</div>
                <p class="wc-footer-desc">Helping travelers discover the beauty of Sri Lanka.</p>
            </div>
            <div class="col-lg-2 col-6">
                <div class="wc-footer-head">PAGES</div>
                <a href="index.php"         class="wc-footer-link">Home</a>
                <a href="plain.html"        class="wc-footer-link">Plan Trip</a>
                <a href="destinations.html" class="wc-footer-link">Destinations</a>
                <a href="itinerary.html"    class="wc-footer-link">Itinerary</a>
                <a href="hotels.html"       class="wc-footer-link">Hotels</a>
                <a href="contact.php"       class="wc-footer-link">Contact</a>
            </div>
            <div class="col-lg-3 col-6">
                <div class="wc-footer-head">DESTINATIONS</div>
                <a href="plain.html" class="wc-footer-link">Kandy</a>
                <a href="plain.html" class="wc-footer-link">Ella</a>
                <a href="plain.html" class="wc-footer-link">Sigiriya</a>
                <a href="plain.html" class="wc-footer-link">Mirissa</a>
                <a href="plain.html" class="wc-footer-link">Nuwara Eliya</a>
            </div>
            <div class="col-lg-3">
                <div class="wc-footer-head">CONTACT US</div>
                <p class="wc-footer-link" style="cursor:default">Mobile: +94 77 123 4567</p>
                <p class="wc-footer-link" style="cursor:default">Email: info@wanderCraft.com</p>
            </div>
        </div>
        <div class="wc-footer-bottom">
            <div class="wc-footer-copy">© 2025 WanderCraft · All Rights Reserved</div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>