<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

/**
 * HomeController
 * Page d'accueil ; liste trajets futurs avec places dispo.
 */
final class HomeController {
    public function index(): string {
        $app =$GLOBALS['app'];

        $trips =$app->trips->listPublic();
        $user =$app->auth->user();

        return View::render('home/index', [
            'trips'=>$trips,
            'user'=>$user,
            'isAdmin'=>$app->auth->isAdmin(),
        ]);
    }
}
