<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Csrf
 * Protection CSRF simple par token en session
 */
final class Csrf {
    private const KEY ='_csrf_token';
    public static function token(): string {
        $token =Session::get(self::KEY);
        if (!$token) {
            $token =bin2hex(random_bytes(32));
            Session::set(self::KEY,$token);
        }
        return $token;
    }
    public static function verify(?string $token): bool {
        return is_string($token) && hash_equals((string) Session::get(self::KEY,''),$token);
    }
}
