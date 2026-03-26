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
                    <li><a class="wc-nav-link" href="index.php">Home</a></li>
                    <li><a class="wc-nav-link" href="plain.php">Plan Trip</a></li>
                    <li><a class="wc-nav-link" href="destinations.php">Destinations</a></li>
                    <li><a class="wc-nav-link active-page" href="itinerary.php">Itinerary</a></li>
                    <li><a class="wc-nav-link" href="hotels.php">Hotels</a></li>
                                    <?php if (isLoggedIn()): ?>
                    <li><a class="wc-nav-link" href="dashboard.php">?? <?= htmlspecialchars(getUsername()) ?></a></li>
                    <li class="ms-2"><a class="wc-nav-cta" href="auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a class="wc-nav-link" href="auth/login.php">Login</a></li>
                    <li class="ms-2"><a class="wc-nav-cta" href="auth/register.php">Register ?</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wc-page-header">
        <div class="container">
            <div class="wc-eyebrow">✦ STEP 3 OF 4</div>
            <h2 class="wc-page-title">Your Itinerary Plan</h2>
            <p class="wc-page-sub">Personalized day-by-day schedule for <span id="itin-dest-sub">Kandy</span></p>
        </div>
    </div>

    <div class="wc-steps-bar">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="wc-step">
                    <div class="wc-step-circle done">✓</div>
                    <div class="ms-2">
                        <div class="wc-step-lbl">Trip Details</div>
                        <div class="wc-step-sub">Locations &amp; dates</div>
                    </div>
                </div>
                <div class="wc-step-line"></div>
                <div class="wc-step">
                    <div class="wc-step-circle done">✓</div>
                    <div class="ms-2">
                        <div class="wc-step-lbl">Recommendations</div>
                        <div class="wc-step-sub">Select places</div>
                    </div>
                </div>
                <div class="wc-step-line"></div>
                <div class="wc-step">
                    <div class="wc-step-circle active">3</div>
                    <div class="ms-2">
                        <div class="wc-step-lbl">Itinerary</div>
                        <div class="wc-step-sub">Your schedule</div>
                    </div>
                </div>
                <div class="wc-step-line"></div>
                <div class="wc-step">
                    <div class="wc-step-circle">4</div>
                    <div class="ms-2">
                        <div class="wc-step-lbl">Hotels</div>
                        <div class="wc-step-sub">Book your stay</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4" style="background:#f4f7fb;">
        <div class="container">
            <div class="row g-4">

                <div class="col-lg-8">
                    <div class="d-flex gap-2 mb-4">
                        <button class="wc-day-tab active-day-tab" id="day1-tab" onclick="switchDay(1)">📅 Day 1</button>
                        <button class="wc-day-tab" id="day2-tab" onclick="switchDay(2)">📅 Day 2</button>
                    </div>
                    <div id="day1-timeline">
                        <div class="wc-timeline" id="day1-content"></div>
                    </div>
                    <div id="day2-timeline" class="d-none">
                        <div class="wc-timeline" id="day2-content"></div>
                    </div>
                    <div class="wc-ov-alert mt-3" id="ov-alert" style="display:none;"></div>
                </div>

                <div class="col-lg-4">
                    <div class="wc-countdown-card mb-3">
                        <div class="wc-cd-label">DAYS UNTIL TRIP</div>
                        <div class="wc-cd-number" id="countdown-num">--</div>
                        <div class="wc-cd-sub">DAYS TO GO ✈</div>
                    </div>
                    <div class="wc-panel mb-3">
                        <div class="wc-side-label mb-3">TRIP SUMMARY</div>
                        <div class="wc-sum-row">
                            <span class="wc-sum-key">📍 Destination</span>
                            <span class="wc-sum-val" id="sum-dest">--</span>
                        </div>
                        <div class="wc-sum-row">
                            <span class="wc-sum-key">📅 Duration</span>
                            <span class="wc-sum-val" id="sum-days">--</span>
                        </div>
                        <div class="wc-sum-row">
                            <span class="wc-sum-key">👥 Travelers</span>
                            <span class="wc-sum-val" id="sum-travelers">--</span>
                        </div>
                        <div class="wc-sum-row">
                            <span class="wc-sum-key">🏛️ Places</span>
                            <span class="wc-sum-val" id="sum-places">--</span>
                        </div>
                        <div class="wc-sum-row">
                            <span class="wc-sum-key">⏱️ Total Time</span>
                            <span class="wc-sum-val" id="sum-time">--</span>
                        </div>
                    </div>
                    <div class="wc-panel mb-3">
                        <div class="wc-side-label mb-3">SELECTED PLACES</div>
                        <div id="selected-places-list">
                            <p class="text-muted small">No places selected yet. <a href="destinations.php">Go back</a></p>
                        </div>
                    </div>
                    <button class="wc-btn-hotels" onclick="window.location.href='hotels.php'">🏨 Book Hotels →</button>
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
                    <p class="wc-footer-desc">Helping travelers discover the beauty of Sri Lanka with smart, time-aware trip planning.</p>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="wc-footer-head">PAGES</div>
                    <a href="index.php" class="wc-footer-link">Home</a>
                    <a href="plain.php" class="wc-footer-link">Plan Trip</a>
                    <a href="destinations.php" class="wc-footer-link">Destinations</a>
                    <a href="itinerary.php" class="wc-footer-link">Itinerary</a>
                    <a href="hotels.php" class="wc-footer-link">Hotels</a>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="wc-footer-head">DESTINATIONS</div>
                    <a href="plain.php" class="wc-footer-link">Kandy</a>
                    <a href="plain.php" class="wc-footer-link">Ella</a>
                    <a href="plain.php" class="wc-footer-link">Sigiriya</a>
                    <a href="plain.php" class="wc-footer-link">Mirissa</a>
                    <a href="plain.php" class="wc-footer-link">Nuwara Eliya</a>
                </div>
                <div class="col-lg-3">
                    <div class="wc-footer-head">CONTACT US</div>
                    <p class="wc-footer-link" style="cursor:default">Mobile: +94 77 123 4567</p>
                    <p class="wc-footer-link" style="cursor:default">Email: info@wanderCraft.com</p>
                    <p class="wc-footer-link" style="cursor:default">Instagram: @wanderCraft</p>
                    <p class="wc-footer-link" style="cursor:default">Facebook: /wanderCraft</p>
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
