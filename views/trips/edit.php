<?php
/** @var array $trip */
/** @var array $agencies */
/** @var string $csrf */
?>

<div class="row justify-content-center">
    <div class="col-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning fw-bold">Modifier mon trajet</div>

            <div class="card-body">

                <form action="/trips/edit/<?= (int)$trip['id'] ?>" method="post">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">

                    <div class="row g-3">

                        <!-- Agence de départ -->
                        <div class="col-6">
                            <label class="form-label">Agence de départ</label>
                            <select class="form-select" name="depart_agency_id" required>
                                <?php foreach ($agencies as $a): ?>
                                    <option value="<?= (int)$a['id'] ?>"
                                        <?= (int)$a['id'] === (int)$trip['depart_agency_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($a['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Agence d'arrivée -->
                        <div class="col-6">
                            <label class="form-label">Agence d'arrivée</label>
                            <select class="form-select" name="arrival_agency_id" required>
                                <?php foreach ($agencies as $a): ?>
                                    <option value="<?= (int)$a['id'] ?>"
                                        <?= (int)$a['id'] === (int)$trip['arrival_agency_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($a['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="forl-lable">Date/heure départ</label>
                            <input type="datetime-local" name="depart_at" class="form-control" value="<?= htmlspecialchars(date('Y-m-d\TH:i',strtotime($trip['depart_at']))) ?>" required>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Date/heure arrivée</label>
                            <input type="datetime-local" name="arrive_at" class="form-control" value="<?= htmlspecialchars(date('Y-m-d\YH:i',strtotime(($trip['arrive_at'])))) ?>" required>
                        </div>

                        <div class="col-4">
                            <label class="form-label">Places totales</label>
                            <input type="number" name="seats-total" min="1" max="8" class="form-control" value="<?= (int)$trip['seats_total'] ?>" required>
                            <div class="form-text">
                                Les places disponibles seront recalculées en conservant les places déjà "prises."
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        /Retour</a>
                        <button class="btn btn-warning" type="submit">Enregistrer</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
