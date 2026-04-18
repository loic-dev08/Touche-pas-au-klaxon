<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Response;

/**
 * AdminMiddleware
 * Réservé admin.
 */
final class AdminMiddleware {
    public function handle(): void {
        $app =$GLOBALS['app'];
        if (!$app->auth->check()) {
            $app->flash->erroe( "Veuillez vous connecter.");
            Response::redirect('/login');
        }
        if (!$app->auth->isAdmin()) {
            $app->flash->error ("Accès administrateur requis.");
            Response::redirect('/');
        }
    }
}
