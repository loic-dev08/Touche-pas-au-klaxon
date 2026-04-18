<?php
/** @var string $content */
$app =$GLOBALS['app'];
$user =$app->auth->user();
$isAdmin =$app->auth->isAdmin();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>
    <!--Pas de version mobile demandée; mais Bootstrap en a une. On garde layout desktop -->
    /assets/css/app.css
</head>
<body class="bg-app">
    <?php require dirname(__DIR__).'/partials/header.php';?>

    <main class="container py-4">
        <?php require dirname(__DIR__).'partials/flash.php'; ?>
        <?= $content ?> 
    </main>

    <?php require dirname(__DIR__).'/partials/footer.php'; ?>

    https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js>/assets/js/app/app.jsscript>

</body>
</html>
