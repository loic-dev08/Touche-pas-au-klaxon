<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);

require $root . '/vendor/autoload.php';

// Chargement des variables d'environnement
$env = [];
$envPath = $root . '/.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
}

// DSN PDO
$dsn = "mysql:host=" . ($env['DB_HOST'] ?? '127.0.0.1') .
    ";dbname=" . ($env['DB_NAME'] ?? 'touche_pas_au_klaxon') .
    ";charset=" . ($env['DB_CHARSET'] ?? 'utf8mb4');

$pdo = new PDO(
    $dsn,
    $env['DB_USER'] ?? 'root',
    $env['DB_PASS'] ?? '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

// Fichiers sources
$agencesFile = __DIR__ . '/sources/agences.txt';
$usersFile   = __DIR__ . '/sources/users.txt';

echo "Seeding agencies...\n";
$pdo->beginTransaction();
try {
    $lines = file($agencesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $st = $pdo->prepare("INSERT IGNORE INTO agencies(name) VALUES(:name)");

    foreach ($lines as $line) {
        $name = trim($line);
        if ($name !== '') {
            $st->execute(['name' => $name]);
        }
    }

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    throw $e;
}

echo "Seeding users...\n";
$pdo->beginTransaction();
try {
    $lines = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $adminEmail = 'alexandre.martin@email.fr';
    $adminPass  = 'Admin@2026!';
    $userPass   = 'User@2026';

    $st = $pdo->prepare("
        INSERT IGNORE INTO users(last_name, first_name, phone, email, role, password_hash)
        VALUES(:last_name, :first_name, :phone, :email, :role, :password_hash)
    ");

    foreach ($lines as $line) {
        $parts = array_map('trim', explode(',', $line));
        if (count($parts) !== 4) continue;

        [$last, $first, $phone, $email] = $parts;
        $role = ($email === $adminEmail) ? 'admin' : 'user';

        $pwd  = ($role === 'admin') ? $adminPass : $userPass;
        $hash = password_hash($pwd, PASSWORD_BCRYPT);

        $st->execute([
            'last_name'     => $last,
            'first_name'    => $first,
            'phone'         => $phone,
            'email'         => $email,
            'role'          => $role,
            'password_hash' => $hash,
        ]);
    }

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    throw $e;
}

echo "Done.\n";
echo "Admin: alexandre.martin@email.fr / Admin@2026!\n";
echo "User:  sophie.dubois@email.fr / User@2026!\n";
