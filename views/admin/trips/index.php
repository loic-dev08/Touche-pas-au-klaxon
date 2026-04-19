<?php
/** @var array $trips */
/** @var string $csrf */
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Trajets</h1>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Agence</th>
            <th>Date</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($trips as $t): ?>
        <tr>
            <td><?= htmlspecialchars($t['start_city']) ?></td>
            <td><?= htmlspecialchars($t['end_city']) ?></td>
            <td><?= htmlspecialchars($t['agency_name']) ?></td>
            <td><?= htmlspecialchars($t['date']) ?></td>

            <td class="text-end">
                <form action="/admin/trips/delete/<?= (int)$t['id'] ?>" method="post" class="d-inline">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce trajet ?');">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
