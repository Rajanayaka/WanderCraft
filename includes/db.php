<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'wandercraft_db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;padding:40px;color:#c00;">
            <h2>Database Connection Failed</h2>
            <p>Please check WAMP is running.</p>
            <p style="color:#888;font-size:12px;">Error: ' . $conn->connect_error . '</p>
         </div>');
}

$conn->set_charset('utf8mb4');
?>