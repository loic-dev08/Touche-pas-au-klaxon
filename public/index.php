<?php
declare(strict_types=1);

use App\Core\App;
use App\Core\Config;
use App\Core\Database;
use App\Core\Session;
use Buki\Router\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

// Démarrage session (flash, auth, csrf)
Session::start();

// Chargement du fichier .env
$envPath = dirname(__DIR__) . '/.env';
if (file_exists($envPath)) {
    foreach (parse_ini_file($envPath) as $k => $v) {
        $_ENV[$k] = $v;
    }
}

// Bootstrap App
$config = new Config($_ENV);
$db = new Database($config);
$app = new App($config, $db);

// Router iziniburak/router (Buki\Router\Router)
$router = new Router([
    'base_folder' => '/',
    'paths' => [
        'controllers' => 'app/Controllers',
        'middlewares' => 'app/Middlewares',
    ],
    'debug' => ($_ENV['APP_DEBUG'] ?? '0') === '1',
]);

// Chargement des routes
require dirname(__DIR__) . '/app/Routes/web.php';
require dirname(__DIR__) . '/app/Routes/admin.php';

// Exécution du router
$router->run();
