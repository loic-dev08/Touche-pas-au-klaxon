<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Session;
use App\Repositories\UserRepository;

/**
 * Class AuthService
 * Gestion login/logout + user courant.
 */
final class AuthService {
    private const SESSION_KEY ='_user_id';
    public function __construct(
        private UserRepository $users,
        private FlashService $flash
    )
    {}

    public function attempt(string $email, string $password): bool {
        $user = $this->users->findByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }
        Session::regenerate();
        Session::set(self::SESSION_KEY,(int)$user['id']);
        return true;
    }
    public function logout(): void {
        Session::regenerate();
        $this->flash->success("Vous êtes déconnecté");
    }
    public function id(): ?int {
        $id = Session::get(self::SESSION_KEY);
        return $id ? (int) $id :null;
    }
    public function user(): ?array {
        $id =$this->id();
        return $id ? $this->users->find($id): null;
    }
    public function check(): bool {
        return $this->id() !==null;
    }
    public function isAdmin(): bool {
        $u =$this->user();
        return $u && ($u['role'] ?? 'user') === 'admin';
    }
        
    }

