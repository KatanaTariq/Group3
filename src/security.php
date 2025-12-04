
<?php
/*******************************************
Developer: Haroon Mohammed
University ID: 240109826
Function: CSRF AND INPUT VALIDATION
*******************************************/
// CENTRAL SECURITY HELPER
// Secure headers

//Reuseable input validation (strings, email, IDs)

//CSRF token generation + verification
// Make sure session exists (needed for CSRF + login)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Send security-related HTTP headers.
 * Call this once per request (e.g. in index.php).
 */
function send_security_headers(): void
{
    // Clickjacking protection
    header('X-Frame-Options: SAMEORIGIN');

    // MIME sniffing protection
    header('X-Content-Type-Options: nosniff');

    // Basic XSS protection header (legacy, but harmless)
    header('X-XSS-Protection: 1; mode=block');

    // Limit referrer information
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Very simple Permissions-Policy example (lock down sensitive APIs)
    header('Permissions-Policy: geolocation=(), camera=(), microphone=()');

    // Basic CSP – you can tweak later as needed
    header(
        "Content-Security-Policy: " .
        "default-src 'self'; " .
        "img-src 'self' data:; " .
        "script-src 'self'; " .
        "style-src 'self' 'unsafe-inline';"
    );
}

/**
 * Sanitize a general string input (names, etc.)
 */
function sanitize_string(string $value): string
{
    $value = trim($value);
    // Remove HTML tags and filter out weird characters
    $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    return $value;
}

/**
 * Validate and normalize an email address.
 * 
 * @return string|null  sanitized email or null if invalid
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
