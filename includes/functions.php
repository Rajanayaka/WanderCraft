<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isValidPassword($password) {
    return strlen($password) >= 8
        && preg_match('/[A-Za-z]/', $password)
        && preg_match('/[0-9]/', $password);
}

function requireLogin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../auth/login.php');
        exit();
    }
}

function redirectWithMessage($url, $type, $message) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash_type']    = $type;
    $_SESSION['flash_message'] = $message;
    header('Location: ' . $url);
    exit();
}

function showFlashMessage() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['flash_message'])) return '';
    $type = $_SESSION['flash_type']    ?? 'success';
    $msg  = $_SESSION['flash_message'] ?? '';
    unset($_SESSION['flash_type'], $_SESSION['flash_message']);
    $bg    = ($type === 'success') ? '#d4edda' : '#f8d7da';
    $color = ($type === 'success') ? '#155724' : '#721c24';
    $icon  = ($type === 'success') ? '✅'      : '⚠️';
    return "<div style=\"background:{$bg};color:{$color};padding:12px 20px;border-radius:8px;
                         margin-bottom:16px;font-family:Nunito,sans-serif;font-size:14px;\">
                {$icon} {$msg}
            </div>";
}

function getUsername() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['username'] ?? '';
}

function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}
?>