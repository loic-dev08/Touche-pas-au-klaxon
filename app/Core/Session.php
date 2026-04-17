<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Class Session
 * Encapsule $_SESSION pour tests et lisibilité.
 */
final class Session
{
    /**
     * Démarre la session si nécessaire.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Récupère une valeur de session.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Définit une valeur en session.
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Supprime une valeur de session.
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Régénère l'identifiant de session.
     */
    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }
}
