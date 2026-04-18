<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\View;

/**
 * TripAdminController (admin)
 * Liste + suppression de n'importe quel trajet.
 */
final class TripAdminController {
    public function index(): string {
        $app =$GLOBALS['app'];

        return View::render('admin/trips/index',[
            'trips' =>$app->trips->listAdmin(),
            'csrf' =>Csrf::token(),
        ]);
    }

    public function delete(int $id): void {
        $app =$GLOBALS['app'];

        if(!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée.");
            Response::redirect('/admin/trips');
        }

        $app->trips->delete($id);
        $app->flash->success("Trajet supprimé.");
        Response::redirect('/admin/trips');
    }
}
