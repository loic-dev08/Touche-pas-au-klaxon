<?php
/** @var \App\Models\User|null $user */
/** @var bool $isAdmin */
?>

<div class="p-4 bg-white shadow-sm rounded">

    <?php if (!$user): ?>
        <h1>Bienvenue sur Touche pas au klaxon</h1>
        <p>Connectez-vous pour proposer ou réserver un trajet.</p>
        <a href="/login" class="btn btn-primary">Connexion</a>

    <?php else: ?>
        <h1>Bonjour <?= htmlspecialchars($user['first_name']) ?> 👋</h1>

        <?php if ($isAdmin): ?>
            <p>Accès administrateur</p>
            <a href="/admin" class="btn btn-warning">Panneau admin</a>
        <?php else: ?>
            <p>Prêt à proposer un trajet ?</p>
            <a href="/trips/create" class="btn btn-success">Créer un trajet</a>
        <?php endif; ?>

    <?php endif; ?>

</div>
