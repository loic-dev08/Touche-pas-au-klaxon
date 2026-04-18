<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

/**
 * UserRepository
 * Accès DB table users (read only côté métier, seed only).
 */
final class UserRepository
{
    public function __construct(private PDO $pdo) {}

    /**
     * Trouve un utilisateur par ID
     */
    public function find(int $id): ?array
    {
        $st = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $st->execute(['id' => $id]);
        $u = $st->fetch();

        return $u ?: null;
    }

    /**
     * Retourne tous les utilisateurs
     */
    public function all(): array
    {
        $st = $this->pdo->query("
            SELECT id, first_name, last_name, email, phone, role
            FROM users
            ORDER BY last_name, first_name
        ");

        return $st->fetchAll();
    }

    /**
     * Insère un utilisateur (seed uniquement)
     */
    public function insert(array $data): int
    {
        $st = $this->pdo->prepare("
            INSERT INTO users (last_name, first_name, phone, email, role, password_hash)
            VALUES (:last_name, :first_name, :phone, :email, :role, :password_hash)
        ");

        $st->execute($data);

        return (int) $this->pdo->lastInsertId();
    }
}
