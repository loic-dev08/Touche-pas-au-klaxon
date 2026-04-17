<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database
 * Wrapper PDO + options sécurisées
 */
final class Database
{
    private PDO $pdo;

    public function __construct(Config $config)
    {
        $user = $config->get('DB_USER', 'root');
        $pass = $config->get('DB_PASS', '');

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO(
                $config->dbDsn(),
                $user,
                $pass,
                $options
            );
        } catch (PDOException $e) {
            // En production : log + page d'erreur
            throw $e;
        }
    }

    /**
     * Retourne l'instance PDO
     */
    public function pdo(): PDO
    {
        return $this->pdo;
    }
}
