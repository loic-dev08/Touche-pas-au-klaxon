<?php
/** @var array $agencies */
/** @var string $csrf */
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Agences</h1>
    /admin/agencies/createCréer une agence</a>

</div>

<table class="table table-hover align-middle">
    <thead><tr><th>Nom</th><th class="text-end">Actions</th></tr></thead>
    <tbody>
        <?php foreach ($agencies as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a['name']) ?></td>
                <td class="text-end">
                    /admin/agencies/edit/<?= (int)$a['id'] ?>Modifier</a>
                    /admin/agencies/delete/<?= (int)$a['id'] ?> class="d-inline">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="btn btn-danger btn btn-sm" type="submit" onclick="return confirm('Supprimer ?');">
                        Supprimer
                    </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>

</table>
