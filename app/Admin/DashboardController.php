<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\View;

/**
 * Dashboard admin
 */
final class DashboardController {
    public function index(): string {
        $app = $GLOBALS['app'];

        return View::render('admin/dashboard', [
            'user' =>$app->auth->user(),
        ]);
    }
}
