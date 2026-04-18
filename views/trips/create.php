<?php
/** @var array $agencies */
/** @var array $user */
/** @var string $csrf */
?>
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary-app text-white fw-bold">
                Proposer un trajet
            </div>

            <div class="card-body">

                <form action="/trips/create" method="post">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">

                    <div class="row g-3">

                        <!-- Agence départ -->
                        <div class="col-6">
                            <label class="form-label">Agence de départ</label>
                            <select class="form-select" name="depart_agency_id" required>
                                <option value="">-- choisir --</option>
                                <?php foreach ($agencies as $a): ?>
                                    <option value="<?= (int)$a['id'] ?>">
                                        <?= htmlspecialchars($a['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Agence arrivée -->
                        <div class="col-6">
                            <label class="form-label">Agence d'arrivée</label>
                            <select class="form-select" name="arrival_agency_id" required>
                                <option value="">-- choisir --</option>
                                <?php foreach ($agencies as $a): ?>
                                    <option value="<?= (int)$a['id'] ?>">
                                        <?= htmlspecialchars($a['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date départ -->
                        <div class="col-6">
                            <label class="form-label">Date/heure départ</label>
                            <input type="datetime-local" name="depart_at" class="form-control" required>
                        </div>

                        <!-- Places -->
                        <div class="col-4">
                            <label class="form-label">Places totales</label>
                            <input type="number" name="seats_total" min="1" max="8" class="form-control" required>
                            <div class="form-text">
                                Les places disponibles seront initialisées automatiquement.
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Infos conducteur -->
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Nom / Prénom</label>
                            <input class="form-control"
                                   value="<?= htmlspecialchars($user['last_name'] . ' ' . $user['first_name']) ?>"
                                   disabled>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Téléphone</label>
                            <input class="form-control"
                                   value="<?= htmlspecialchars($user['phone']) ?>"
                                   disabled>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input class="form-control"
                                   value="<?= htmlspecialchars($user['email']) ?>"
                                   disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="/trips" class="btn btn-outline-secondary me-2">Annuler</a>
                        <button class="btn btn-primary-app" type="submit">Créer</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
