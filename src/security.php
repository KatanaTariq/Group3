<?php
// CENTRAL SECURITY HELPER

// Make session cookies harder to steal/use.
// Do this before session_start().
if (session_status() === PHP_SESSION_NONE) {
    $isHttps =
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

    // Harden session handling without changing how other files use sessions.
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    if ($isHttps) {
        ini_set('session.cookie_secure', '1');
    }

    // Set SameSite in a backward-friendly way.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams['lifetime'],
        'path'     => $cookieParams['path'],
        'domain'   => $cookieParams['domain'],
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();

    // Regenerate once per session bootstrap to reduce session fixation risk
    // without constantly rotating IDs during normal usage.
    if (empty($_SESSION['_session_regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['_session_regenerated'] = time();
    }
}

/**
 * Send security-related HTTP headers.
 * Call this once per request (e.g. in index.php).
 */
function send_security_headers(): void
{
    $isHttps =
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

    // Existing headers
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), camera=(), microphone=()');

    // Extra safe headers that should not change app behavior
    header('Cross-Origin-Opener-Policy: same-origin');
    header('Cross-Origin-Resource-Policy: same-origin');

    // Only send HSTS over HTTPS
    if ($isHttps) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    // Basic CSP, slightly tightened without changing normal same-origin behavior
    header(
        "Content-Security-Policy: " .
        "default-src 'self'; " .
        "img-src 'self' data:; " .
        "script-src 'self'; " .
        "style-src 'self' 'unsafe-inline'; " .
        "object-src 'none'; " .
        "base-uri 'self'; " .
        "frame-ancestors 'self';"
    );
}

/**
 * Sanitise a general string input (names, etc.)
 */
function sanitise_string(string $value): string
{
    $value = trim($value);
    return $value;
}

/**
 * Validate and normalise an email address.
 *
 * @return string|null sanitised email or null if invalid
 */
function validate_email(string $value): ?string
{
    $value = trim($value);
    $value = filter_var($value, FILTER_SANITIZE_EMAIL);

    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return null;
    }

    return $value;
}

/**
 * Helper for validating integer IDs (e.g. from GET/POST).
 */
function validate_int_id($value): ?int
{
    if (!isset($value) || $value === '') {
        return null;
    }

    if (filter_var($value, FILTER_VALIDATE_INT) === false) {
        return null;
    }

    return (int)$value;
}

/* ===========================
   CSRF PROTECTION
   =========================== */

/**
 * Get (or create) the CSRF token for the current session.
 */
function get_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Verify a CSRF token sent by the client.
 */
function verify_csrf_token(?string $tokenFromRequest): bool
{
    if (empty($_SESSION['csrf_token']) || empty($tokenFromRequest)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $tokenFromRequest);
}
