<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\View;

/**
 * TripController
 * CRUD trajets (utilisateur connecté, édition/suppression uniquement auteur).
 */
final class TripController
{
    public function createForm(): string
    {
        $app = $GLOBALS['app'];

        return View::render('trips/create', [
            'agencies' => $app->agencies->all(),
            'user'     => $app->auth->user(),
            'errors'   => [],
            'csrf'     => Csrf::token(),
            'old'      => [],
        ]);
    }

    public function store(): void
    {
        $app = $GLOBALS['app'];

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée. Veuillez réessayer.");
            Response::redirect('/trips/create');
        }

        $user = $app->auth->user();

        $data = [
            'depart_agency_id'  => (int)($_POST['depart_agency_id'] ?? 0),
            'arrival_agency_id' => (int)($_POST['arrival_agency_id'] ?? 0),
            'depart_at'         => (string)($_POST['depart_at'] ?? ''),
            'arrive_at'         => (string)($_POST['arrive_at'] ?? ''),
            'seats_total'       => (int)($_POST['seats_total'] ?? 0),
        ];

        $errors = $app->validator->validateTrip($data);

        if ($errors) {
            $app->flash->error("Veuillez corriger les erreurs du formulaire.");
            Response::redirect('/trips/create');
        }

        $payload = [
            'depart_agency_id'  => $data['depart_agency_id'],
            'arrival_agency_id' => $data['arrival_agency_id'],
            'depart_at'         => $data['depart_at'],
            'arrive_at'         => $data['arrive_at'],
            'seats_total'       => $data['seats_total'],
            'seats_available'   => $data['seats_total'],
            'contact_user_id'   => (int)$user['id'],
            'author_user_id'    => (int)$user['id'],
        ];

        $app->trips->create($payload);

        $app->flash->success("Trajet créé avec succès.");
        Response::redirect('/');
    }

    public function editForm(int $id): string
    {
        $app = $GLOBALS['app'];

        $trip = $app->trips->find($id);
        if (!$trip) {
            $app->flash->error("Trajet introuvable.");
            Response::redirect('/');
        }

        $user = $app->auth->user();

        if ((int)$trip['author_user_id'] !== (int)$user['id']) {
            $app->flash->error("Vous ne pouvez modifier que vos trajets.");
            Response::redirect('/');
        }

        return View::render('trips/edit', [
            'trip'     => $trip,
            'agencies' => $app->agencies->all(),
            'csrf'     => Csrf::token(),
        ]);
    }

    public function update(int $id): void
    {
        $app = $GLOBALS['app'];

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée. Veuillez réessayer.");
            Response::redirect("/trips/edit/$id");
        }

        $trip = $app->trips->find($id);
        if (!$trip) {
            $app->flash->error("Trajet introuvable.");
            Response::redirect('/');
        }

        $user = $app->auth->user();
        if ((int)$trip['author_user_id'] !== (int)$user['id']) {
            $app->flash->error("Vous ne pouvez modifier que vos trajets.");
            Response::redirect('/');
        }

        $data = [
            'depart_agency_id'  => (int)($_POST['depart_agency_id'] ?? 0),
            'arrival_agency_id' => (int)($_POST['arrival_agency_id'] ?? 0),
            'depart_at'         => (string)($_POST['depart_at'] ?? ''),
            'arrive_at'         => (string)($_POST['arrive_at'] ?? ''),
            'seats_total'       => (int)($_POST['seats_total'] ?? 0),
        ];

        $errors = $app->validator->validateTrip($data);
        if ($errors) {
            $app->flash->error("Veuillez corriger les erreurs.");
            Response::redirect("/trips/edit/$id");
        }

        // Calcul du nombre de places disponibles après modification
        $taken = (int)$trip['seats_total'] - (int)$trip['seats_available'];
        $newAvailable = max(0, $data['seats_total'] - $taken);

        $app->trips->update($id, [
            'depart_agency_id'  => $data['depart_agency_id'],
            'arrival_agency_id' => $data['arrival_agency_id'],
            'depart_at'         => $data['depart_at'],
            'arrive_at'         => $data['arrive_at'],
            'seats_total'       => $data['seats_total'],
            'seats_available'   => $newAvailable,
        ]);

        $app->flash->success("Trajet modifié avec succès.");
        Response::redirect('/');
    }

    public function delete(int $id): void
    {
        $app = $GLOBALS['app'];

        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            $app->flash->error("Session expirée.");
            Response::redirect('/');
        }

        $trip = $app->trips->find($id);
        if (!$trip) {
            $app->flash->error("Trajet introuvable.");
            Response::redirect('/');
        }

        $user = $app->auth->user();
        if ((int)$trip['author_user_id'] !== (int)$user['id']) {
            $app->flash->error("Vous ne pouvez supprimer que vos trajets.");
            Response::redirect('/');
        }

        $app->trips->delete($id);

        $app->flash->success("Trajet supprimé avec succès.");
        Response::redirect('/');
    }
}
