<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Response
 * Redirections et réponses HTML.
 */
final class Response {
    public static function redirect(string $path): void {
        header('Location:'.$path);
        exit;
    }
}
