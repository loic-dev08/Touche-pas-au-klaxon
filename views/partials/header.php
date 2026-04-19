<?php
/** @var \App\Models\User|null $user */
/** @var bool $isAdmin */
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary-app">
    <div class="container">

        <a class="navbar-brand" href="<?= $isAdmin ? '/admin' : '/' ?>">
            Touche pas au klaxon
        </a>

        <div class="d-flex align-items-center gap-3">

            <?php if (!$user): ?>

                <a href="/login" class="btn btn-outline-light">Connexion</a>

            <?php else: ?>

                <?php if ($isAdmin): ?>
                    <a href="/admin/users" class="btn btn-outline-light">Utilisateurs</a>
                    <a href="/admin/agencies" class="btn btn-outline-light">Agences</a>
                    <a href="/admin/trips" class="btn btn-outline-light">Trajets</a>

                <?php else: ?>
                    <a href="/trips/create" class="btn btn-outline-light">Proposer un trajet</a>

                    <span class="text-white ms-2">
                        <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                    </span>
                <?php endif; ?>

                <form action="/logout" method="post" class="d-inline">
                    <input type="hidden" name="_csrf" value="<?= \App\Core\Csrf::token() ?>">
                    <button class="btn btn-danger" type="submit">Déconnexion</button>
                </form>

            <?php endif; ?>

        </div>
    </div>
</nav>
