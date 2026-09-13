<?php
/**
 * StockWise Retail Solutions - Shared helper functions
 * ---------------------------------------------------
 * Session bootstrap, input sanitisation, CSRF protection,
 * flash messaging and simple role-based access control helpers.
 */

if (session_status() === PHP_SESSION_NONE) {
    // Harden the session cookie a little before starting it.
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,   // JS cannot read the session cookie
        'samesite' => 'Lax',
    ]);
    session_start();
}

/** Escape output for safe HTML display (XSS protection). */
function h($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** Trim + strip tags from user supplied text. */
function clean_input($value)
{
    return trim(strip_tags($value ?? ''));
}

/** Generate (or reuse) a CSRF token for the current session. */
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Output a hidden CSRF field ready to drop inside a <form>. */
function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

/** Verify a submitted CSRF token, halting the request if it does not match. */
function verify_csrf()
{
    $submitted = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $submitted)) {
        http_response_code(400);
        die('Your session has expired or the request looks invalid. Please go back and try again.');
    }
}

/** Store a one-time flash message shown on the next page load. */
function set_flash($type, $message)
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

/** Pop and return all flash messages (used once, then cleared). */
function get_flashes()
{
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

/** Is a user currently logged in? */
function is_logged_in()
{
    return !empty($_SESSION['user_id']);
}

/** Return the logged in user's role, or null. */
function current_role()
{
    return $_SESSION['user_role'] ?? null;
}

/** Redirect helper that always stops script execution. */
function redirect($path)
{
    header('Location: ' . $path);
    exit;
}

/** Force login before continuing; remembers where to return to. */
function require_login()
{
    if (!is_logged_in()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? '';
        set_flash('error', 'Please log in to continue.');
        redirect('/login.php');
    }
}

/**
 * Restrict a page to one or more roles, e.g. require_role('admin')
 * or require_role(['admin', 'staff']).
 */
function require_role($roles)
{
    require_login();
    $roles = (array) $roles;
    if (!in_array(current_role(), $roles, true)) {
        http_response_code(403);
        set_flash('error', 'You do not have permission to view that page.');
        redirect('/dashboard.php');
    }
}

/** Basic path helper so links work whether the app sits in a sub-folder or not. */
function base_url($path = '')
{
    return rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\') . '/' . ltrim($path, '/');
}
