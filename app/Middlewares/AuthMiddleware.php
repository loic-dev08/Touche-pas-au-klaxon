<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Response;

/**
 * AuthMiddleware
 * Bloque l'accès si non connecté
 */
final class AuthMiddleware {
    public function handle(): void {
        $app = $GLOBALS['app'];
        if (!$app->auth->check()) {
            $app->flash->error("Veuillez vous connecter.");
            Response::redirect('/login');
        }

    }
}   

