<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Csrf;
use App\Core\Response;

/**
 * CsrfMiddleware
 * Vérifie le token CSRF
 */
final class CsrfMiddleware {
    public function handle(): void {
        $token =$_POST['csrf'] ?? null;
        if(!Csrf::verify($token)) {
            $app = $GLOBALS['app'];
            $app->flash->eror("Session expirée. Veuillez réessayer.");
            Response::redirect($_SERVER['HTTP_REFERER'] ??'/');
        }
    }
}
