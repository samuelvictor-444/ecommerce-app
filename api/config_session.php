<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// Configure session cookies
$cookieParams = [
    'lifetime' => 1800,       // 30 minutes
    'path'     => '/',         // accessible site-wide
    'domain'   => 'localhost', // change to your domain in production
    'secure'   => false,       // true on HTTPS, false for localhost testing
    'httponly' => true,        // JavaScript cannot access
    'samesite' => 'Strict'     // prevent CSRF
];
session_set_cookie_params($cookieParams);

// Start or resume session
session_name("MySecureSession");
session_start();

// ==============================
// Session Regeneration (every 30 mins)
// ==============================
$regeneration_interval = 60 * 30; // 30 minutes

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    if (time() - $_SESSION['last_regeneration'] >= $regeneration_interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// ==============================
// Optional: Session Timeout
// ==============================
$timeout = 60 * 30; // 30 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    // Destroy session after timeout
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // remove cookie
}

$_SESSION['LAST_ACTIVITY'] = time();

// ==============================
// Utility functions
// ==============================

function is_logged_in(): bool
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function login_user(int $user_id, string $email , string $firstName)
{
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_firstName'] =$firstName; 
    $_SESSION['logged_in'] = true;

    // regenerate ID after login
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

if (!isset($_SESSION['user_agent'])) {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
} elseif ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    logout_user(); // force logout if user agent changes
}

function logout_user()
{
    $_SESSION = [];
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
}
