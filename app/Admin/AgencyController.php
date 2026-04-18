<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\View;

/**
 * AgencyController (admin)
 * CRUD agences (seul admin)
 */
final class AgencyController
{
    public function index(): string
    {
        $app = $GLOBALS['app'];

        return View::render('admin/agencies/index', [
            'agencies' => $app->agencies->all(),
            'csrf'     => Csrf::token(),
        ]);
    }

    public function createForm(): string
    {
        return View::render('admin/agencies/create', [
            'csrf'   => Csrf::token(),
            'errors' => [],
        ]);
    }

    public function store(): void
    {
        $app = $GLOBALS['app'];

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée.");
            Response::redirect('/admin/agencies');
        }

        $errors = $app->validator->validateAgency($_POST);
        if ($errors) {
            $app->flash->error("Veuillez corriger les erreurs.");
            Response::redirect('/admin/agencies/create');
        }

        $app->agencies->create(trim((string)$_POST['name']));
        $app->flash->success("Agence créée.");
        Response::redirect('/admin/agencies');
    }

    public function editForm(int $id): string
    {
        $app = $GLOBALS['app'];

        $agency = $app->agencies->find($id);
        if (!$agency) {
            $app->flash->error("Agence introuvable.");
            Response::redirect('/admin/agencies');
        }

        return View::render('admin/agencies/edit', [
            'agency' => $agency,
            'csrf'   => Csrf::token(),
        ]);
    }

    public function update(int $id): void
    {
        $app = $GLOBALS['app'];

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée.");
            Response::redirect('/admin/agencies');
        }

        $errors = $app->validator->validateAgency($_POST);
        if ($errors) {
            $app->flash->error("Veuillez corriger les erreurs.");
            Response::redirect("/admin/agencies/edit/{$id}");
        }

        $app->agencies->update($id, trim((string)$_POST['name']));
        $app->flash->success("Agence modifiée.");
        Response::redirect('/admin/agencies');
    }

    public function delete(int $id): void
    {
        $app = $GLOBALS['app'];

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée.");
            Response::redirect('/admin/agencies');
        }

        $app->agencies->delete($id);
        $app->flash->success("Agence supprimée.");
        Response::redirect('/admin/agencies');
    }
}
