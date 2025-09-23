<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// Configure session cookies
$cookieParams = [
    'lifetime' => 1800,       // 30 minutes
    'path'     => '/',         // accessible site-wide
    'domain'   => 'abaprice.rf.gd',          // <-- empty = works for localhost, 127.0.0.1, or custom host
    'secure'   => true,       // true on HTTPS, false for localhost testing
    'httponly' => true,        // JavaScript cannot access
    'samesite' => 'Lax'     // prevent CSRF
];
session_set_cookie_params($cookieParams);

define("PAYSTACK_SECRET_KEY","sk_test_5ee577d576e335158c9260ae257fd54785dc6611");

// Start or resume session
session_name("MySecureSession");
session_start();

// ==============================
// Session Regeneration (every 30 mins)
// ==============================
$regeneration_interval = 60 * 30; // 30 minutes

if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] >= $regeneration_interval) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// ==============================
// Optional: Session Timeout
// ==============================
$timeout = 60 * 30; // 30 minutes

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    logout_user(); // just destroy, no JSON
}
$_SESSION['LAST_ACTIVITY'] = time();

// ==============================
// Utility functions
// ==============================

function is_logged_in(): bool
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function login_user(int $user_id, string $email, string $firstName)
{
    $_SESSION['user_id']       = $user_id;
    $_SESSION['user_email']    = $email;
    $_SESSION['user_firstName']= $firstName;
    $_SESSION['logged_in']     = true;

    // regenerate ID after login
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// ==============================
// User agent lock (less strict)
// ==============================
if (!isset($_SESSION['user_agent'])) {
    $_SESSION['user_agent'] = substr($_SERVER['HTTP_USER_AGENT'], 0, 50);
} elseif (substr($_SESSION['user_agent'], 0, 50) !== substr($_SERVER['HTTP_USER_AGENT'], 0, 50)) {
    logout_user();
}

// ==============================
// Logout function
// ==============================
function logout_user(bool $sendResponse = false)
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_unset();
    session_destroy();

    if ($sendResponse) {
        header('Content-Type: application/json');
        echo json_encode(["success" => true, "message" => "Logged out successfully"]);
        exit;
    }
}
