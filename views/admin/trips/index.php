<?php
/** @var array $trips */
/** @var string $csrf */
?>

<h1 class="h4 mb-3">Tous les trajets (admin)</h1>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Départ</th><th>Arrivée</th><th>Départ</th><th>Arrivée</th><th>Places</th><th>Auteur</th><th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trips as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['depart_agency']) ?></td>
                <td><?= htmlspecialchars($t['arrival_agency']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y H:i',strtotime($t['depart_at']))) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['arrive_at']))) ?></td>
                <td><?= (int)$t['seats_available'] ?>/<?= (int)$t['seats_total'] ?></td>
                <td><?= htmlspecialchars($t['first_name'].''.$t['last_name']) ?></td>
                <td class="text-end">
                    /admin/trips/delete/<?= (int)$t['id'] ?> class="d-inline">
                    <input type="hiddden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="btn btn-danger btn btn-sm" type="submit" onclick="return confirm('Supprimer ?')">
                        Supprimer
                    </button>
                </form>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>