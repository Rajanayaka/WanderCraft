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
                    <li><a class="wc-nav-link active-page" href="plain.php">Plan Trip</a></li>
                    <li><a class="wc-nav-link" href="destinations.php">Destinations</a></li>
                    <li><a class="wc-nav-link" href="itinerary.php">Itinerary</a></li>
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
            <div class="wc-eyebrow">✦ STEP 1 OF 4</div>
            <h2 class="wc-page-title">Plan Your Trip</h2>
            <p class="wc-page-sub">Fill in your details and we'll craft the perfect itinerary</p>
        </div>
    </div>

    <div class="wc-steps-bar">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="wc-step">
                    <div class="wc-step-circle active">1</div>
                    <div class="ms-2">
                        <div class="wc-step-lbl">Trip Details</div>
                        <div class="wc-step-sub">Locations &amp; dates</div>
                    </div>
                </div>
                <div class="wc-step-line"></div>
                <div class="wc-step">
                    <div class="wc-step-circle">2</div>
                    <div class="ms-2">
                        <div class="wc-step-lbl">Recommendations</div>
                        <div class="wc-step-sub">Select places</div>
                    </div>
                </div>
                <div class="wc-step-line"></div>
                <div class="wc-step">
                    <div class="wc-step-circle">3</div>
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

                <div class="col-lg-6">
                    <div class="wc-panel h-100">
                        <div class="wc-panel-title">
                            <div class="wc-panel-icon">📍</div> Locations
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">STARTING CITY</label>
                            <input type="text" class="wc-input" placeholder="e.g. Colombo, Negombo..."/>
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">DESTINATION</label>
                            <input type="text" id="inp-dest" class="wc-input" placeholder="e.g. Kandy, Ella, Sigiriya..." oninput="updatePreview()"/>
                            <div id="err-dest" class="wc-err d-none">⚠ Please enter a destination</div>
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">TRAVEL START DATE</label>
                            <input type="date" id="inp-date" class="wc-input" oninput="updatePreview()"/>
                            <div id="err-date" class="wc-err d-none">⚠ Please select a travel date</div>
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">DESTINATION TYPE</label>
                            <select class="wc-select">
                                <option value="">Select type...</option>
                                <option>Cultural &amp; Heritage</option>
                                <option>Nature &amp; Scenery</option>
                                <option>Adventure</option>
                                <option>Religious</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="wc-panel h-100">
                        <div class="wc-panel-title">
                            <div class="wc-panel-icon">👥</div> Travelers &amp; Duration
                        </div>
                        <div class="mb-4">
                            <label class="wc-label">NUMBER OF TRAVELERS</label>
                            <div class="wc-counter mt-2">
                                <button class="wc-cnt-btn" onclick="changeCount(-1)">−</button>
                                <div class="wc-cnt-val" id="traveler-count">2</div>
                                <button class="wc-cnt-btn" onclick="changeCount(1)">+</button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="wc-label">NUMBER OF DAYS</label>
                            <div class="d-flex gap-2 flex-wrap mt-2">
                                <button class="wc-pill" onclick="selectDays(this,1)">1 Day</button>
                                <button class="wc-pill active-pill" onclick="selectDays(this,2)">2 Days</button>
                                <button class="wc-pill" onclick="selectDays(this,3)">3 Days</button>
                                <button class="wc-pill" onclick="selectDays(this,4)">4 Days</button>
                                <button class="wc-pill" onclick="selectDays(this,5)">5+</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">TRAVEL METHOD</label>
                            <select class="wc-select">
                                <option>By Car / Taxi</option>
                                <option>By Bus</option>
                                <option>By Train</option>
                                <option>By Tuk-tuk</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="wc-panel">
                        <div class="wc-panel-title">
                            <div class="wc-panel-icon">❤️</div>
                            Must-Visit Places
                            <span style="font-size:12px;color:#7a8fa6;font-weight:400;font-style:italic;margin-left:6px">Optional</span>
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">PLACES YOU DEFINITELY WANT TO VISIT</label>
                            <div class="wc-tags-wrap" id="tags-container">
                                <span class="wc-tag">Temple of Tooth <span onclick="removeTag(this)">✕</span></span>
                                <span class="wc-tag">Peradeniya Garden <span onclick="removeTag(this)">✕</span></span>
                                <button class="wc-tag-add" onclick="addTag()">+ Add Place</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="wc-label">SPECIAL NOTES</label>
                            <input type="text" class="wc-input" placeholder="e.g. Prefer morning visits, avoid crowds..."/>
                        </div>
                        <div class="wc-live-box mt-3">
                            <div class="wc-live-label">✦ LIVE TRIP PREVIEW</div>
                            <div class="wc-live-main">
                                You are planning a <em id="lp-days">2-day</em> trip to <em id="lp-dest">your destination</em>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <span class="wc-live-chip">👥 <strong id="lp-travelers">2</strong> travelers</span>
                                <span class="wc-live-chip">⏱️ <strong id="lp-hours">16h</strong> available</span>
                                <span class="wc-live-chip">📅 <strong id="lp-date">Not set</strong></span>
                            </div>
                        </div>
                        <button class="wc-btn-generate mt-4" onclick="goToReco()">
                            <a href="destinations.php" class="wc-btn-primary">✦ GENERATE MY ITINERARY →</a>
                        </button>
                    </div>
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
