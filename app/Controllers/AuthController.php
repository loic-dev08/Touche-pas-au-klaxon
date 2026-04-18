<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\View;
use RequestParseBodyException;

/**
 * AuthController
 * Connexion/Déconnexion
 */
final class AuthController {
    public function showLogin(): string {
        $app =$GLOBALS['app'];
        if ($app->auth->check()) {
            Response::redirect('/');
        }
        return View::render('auth/login',['csrf' => Csrf::token()]);
    }

    public function login(): void {
        $app =$GLOBALS['app'];
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée, réessayez.");
            Response::redirect('/login');
        }

        $email =trim((string)$_POST['email'] ?? '');
        $password =(string)($_POST['password'] ?? '');

        if ($app->auth->attempt($email, $password)) {
            $app->flash->success("Connexion réussie.");
            Response::redirect('/');
        }

        $app->flash->error("Identifiants invalides");
        Response::redirect('/login');
    }

    public function logout(): void {
        $app =$GLOBALS['app'];
        $app->auth->logout();
        Response::redirect('/');
    }
}
