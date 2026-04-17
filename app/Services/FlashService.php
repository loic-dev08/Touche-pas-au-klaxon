<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Session;

/**
 * Class FlashService
 * Message flash: défini une fois, lu une fois.
 */
final class FlashService {
    private const KEY ='_flash';
    public function success (string $message): void {
        $this->set('success',$message);
    }
    public function error(string $message): void {
        $this->set('danger',$message);
    }
    private function set(string $type,string $message): void {
        Session::set(self::KEY,['type' =>$type,'message'=>$message]);
    }
    public function pull(): ?array {
        $flash =Session::get(self::KEY);
        if($flash) {
            Session::remove(self::KEY);
        }
        return $flash ?:null;
    }
}
