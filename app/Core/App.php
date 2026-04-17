<?php
declare(strict_types=1);

namespace App\Core;

use App\Repositories\AgencyRepository;
use App\Repositories\TripRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\FlashService;
use App\Services\Validator;

/**
 * Class App
 * Mini-container :expose services/repositories.
 */
final class App {
    public readonly UserRepository $users;
    public readonly AgencyRepository$agencies;
    public readonly TripRepository $trips;

    public readonly AuthService $auth;
    public readonly FlashService $flash;
    public readonly Validator $validator;

    public function __construct(
        public readonly Config $config,
        public readonly Database $db
    )
    {
        $pdo =$db->pdo();

        $this->users = new UserRepository($pdo);
        $this->agencies = new AgencyRepository($pdo);
        $this->trips = new TripRepository($pdo);

        $this->flash = new FlashService();
        $this->auth = new AuthService($this->users,$this->flash);
        $this->validator = new Validator();
        
    }
}