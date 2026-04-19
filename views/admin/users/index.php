<?php
/** @var array $users */
/** @var string $csrf */
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Utilisateurs</h1>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Admin</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['is_admin'] ? 'Oui' : 'Non' ?></td>

            <td class="text-end">
                <form action="/admin/users/delete/<?= (int)$u['id'] ?>" method="post" class="d-inline">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?');">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
