<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Csrf;

final class DashboardController
{
    public function index(): string
    {
        $app = $GLOBALS['app']; // OK dans un contrôleur

        return View::render('admin/dashboard', [
            'user'    => $app->auth->user(),
            'isAdmin' => $app->auth->isAdmin(),
            'csrf'    => Csrf::token(),
        ]);
    }
}
