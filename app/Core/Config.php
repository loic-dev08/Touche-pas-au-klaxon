<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Config
 * Gestion centralisée des paramètres d'environnement (.env).
 */
final class Config
{
    public function __construct(private array $env)
    {
    }

    /**
     * Récupère une valeur d'environnement.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->env[$key] ?? $default;
    }

    /**
     * Construit le DSN pour PDO.
     */
    public function dbDsn(): string
    {
        $host    = $this->get('DB_HOST', '127.0.0.1');
        $name    = $this->get('DB_NAME', 'tpk');
        $charset = $this->get('DB_CHARSET', 'utf8mb4');

        return "mysql:host={$host};dbname={$name};charset={$charset}";
    }
}


