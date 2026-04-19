<?php
declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

// Charger les variables d'environnement du phpunit.xml
foreach ($_SERVER as $k => $v) {
    if (str_starts_with($k, 'DB_')) {
        putenv("$k=$v");
    }
}

function testPdo(): PDO {
    $dsn = "mysql:host=" . getenv('DB_HOST') .
        ";dbname=" . getenv('DB_NAME') .
        ";charset=" . getenv('DB_CHARSET');

    return new PDO(
        $dsn,
        getenv('DB_USER') ?: 'root',
        getenv('DB_PASS') ?: '',
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}
