<?php
/** @var array $trips */
/** @var array|null $user */

$app          = $GLOBALS['app'];
$isLogged     = $app->auth->check();
$currentUser  = $app->auth->user();
$csrf         = \App\Core\Csrf::token();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Trajets disponibles</h1>

    <?php if ($isLogged && !$app->auth->isAdmin()): ?>
        <a href="/trips/create" class="btn btn-primary">Proposer un trajet</a>
    <?php endif; ?>
</div>

<?php if (empty($trips)): ?>

    <div class="alert alert-info">Aucun trajet pour le moment</div>

<?php else: ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Départ</th>
                    <th>Date départ</th>
                    <th>Arrivée</th>
                    <th>Date arrivée</th>
                    <th>Places dispo</th>
                    <?php if ($isLogged): ?>
                        <th class="text-end">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($trips as $t): ?>
                    <tr>
                        <td class="fw-semibold">
                            <?= htmlspecialchars($t['depart_agency']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['depart_at']))) ?>
                        </td>

                        <td class="fw-semibold">
                            <?= htmlspecialchars($t['arrival_agency']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['arrive_at']))) ?>
                        </td>

                        <td>
                            <span class="badge bg-success">
                                <?= (int)$t['seats_available'] ?> / <?= (int)$t['seats_total'] ?>
                            </span>
                        </td>

                        <?php if ($isLogged): ?>
                            <td class="text-end">

                                <!-- Bouton détails -->
                                <button 
                                    class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#tripModal<?= (int)$t['id'] ?>"
                                >
                                    Détails
                                </button>

                                <?php if ((int)$t['author_user_id'] === (int)$currentUser['id']): ?>

                                    <!-- Modifier -->
                                    <a href="/trips/edit/<?= (int)$t['id'] ?>" 
                                       class="btn btn-warning btn-sm">
                                        Modifier
                                    </a>

                                    <!-- Supprimer -->
                                    <form action="/trips/delete/<?= (int)$t['id'] ?>" 
                                          method="post" 
                                          class="d-inline">
                                        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                                        <button 
                                            class="btn btn-danger btn-sm" 
                                            type="submit"
                                            onclick="return confirm('Supprimer ce trajet ?');"
                                        >
                                            Supprimer
                                        </button>
                                    </form>

                                <?php endif; ?>

                            </td>
                        <?php endif; ?>
                    </tr>

                    <!-- Modal -->
                    <?php if ($isLogged): ?>
                        <div class="modal fade" id="tripModal<?= (int)$t['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary-app text-white">
                                        <h5 class="modal-title">Informations complémentaires</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-1"><strong>Proposé par:</strong>
                                        <?= htmlspecialchars($t['first_name'].''.$t['last_name']) ?>
                                    </p>
                                    <p class="mb-1"><strong>Téléphone</strong><?= htmlspecialchars($t['phone']) ?>
                                    </p>
                                    <p class="mb-1"><strong>Email</strong><?= htmlspecialchars($t['email']) ?>
                                    </p>
                                    <hr>
                                    <p class="mb-0"><strong>Places totales</strong><?= (int)$t['seats_total'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

                            