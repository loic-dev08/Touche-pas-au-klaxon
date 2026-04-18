<?php
/** @var array $users */
?>

<h1 class="h4 mb-3">Utilisateurs (lecture seule)</h1>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th><th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['last_name']) ?></td>
                    <td><?= htmlspecialchars($u['first_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['phone']) ?></td>
                    <td><span class="badge bg<?= $u['role']==='admin'?'danger':'secondary'?>"><?=htmlspecialchars($u['role'])?></span></td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
