<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\View;

/**
 * UserController (admin)
 * Listening uniquement (pas de CRUD employés).
 */
final class UserController {
    public function index(): string {
        $app =$GLOBALS['app'];

        return View::render('admin/Users/index', [
            'users' =>$app->users->all(),
        ]);
    }
}
