<?php
/** @var string $content */
/** @var \App\Models\User|null $user */
/** @var bool $isAdmin */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>

    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="bg-app">

    <?php require dirname(__DIR__) . '/partials/header.php'; ?>

    <main class="container py-4">
        <?php require dirname(__DIR__) . '/partials/flash.php'; ?>
        <?= $content ?>
    </main>

    <?php require dirname(__DIR__) . '/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>

</body>
</html>
