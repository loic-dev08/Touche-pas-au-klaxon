<?php
/** @var array $user */
?>

<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4">Tableau de bord administrateur</h1>
        <p class="mb-0">Bievenue,<strong><?= htmlspecialchars($user['first_name'].''.$user['last_name']) ?></strong></p>
        <hr>
        <div class="d-flex gap-2">
            /admin/UsersLister utilisateurs</a>
            /admin/agenciesGérer agences</a>
            /admin/tripsLister trajets</a>
        </div>
    </div>
</div>
