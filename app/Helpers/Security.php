<?php
declare(strict_types=1);

namespace App\Helpers;

class Security
{
    private static ?string $csrfToken = null;

    public static function e(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function startSession(): void
    {
        if (function_exists('session_status')) {
            if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
                @session_start([
                    'cookie_httponly' => true,
                    'cookie_samesite' => 'Lax',
                    'use_strict_mode' => true,
                ]);
            }
        }
    }

    public static function csrfToken(): string
    {
        if (self::$csrfToken !== null) {
            return self::$csrfToken;
        }

        self::startSession();

        if (function_exists('session_status') && session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['csrf_token'])) {
            self::$csrfToken = $_SESSION['csrf_token'];
            return self::$csrfToken;
        }

        // Cookie-backed / cryptographically secure token
        $cookieToken = $_COOKIE['lufly_csrf'] ?? null;
        if ($cookieToken && strlen($cookieToken) === 64 && ctype_xdigit($cookieToken)) {
            self::$csrfToken = $cookieToken;
        } else {
            self::$csrfToken = bin2hex(random_bytes(32));
            if (!headers_sent()) {
                setcookie('lufly_csrf', self::$csrfToken, [
                    'expires' => time() + 86400 * 7,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }
        }

        if (function_exists('session_status') && session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['csrf_token'] = self::$csrfToken;
        }

        return self::$csrfToken;
    }

    public static function csrfField(): string
    {
        $token = self::csrfToken();
        return '<input type="hidden" name="csrf_token" value="' . self::e($token) . '">';
    }

    public static function verifyCsrf(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $expected = self::csrfToken();
        return hash_equals($expected, $token);
    }

    public static function sanitizeString(string $input): string
    {
        $clean = strip_tags($input);
        return trim(preg_replace('/\s+/', ' ', $clean) ?? '');
    }

    public static function sanitizeEmail(string $email): ?string
    {
        $clean = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        return $clean !== false ? (string)$clean : null;
    }
}
