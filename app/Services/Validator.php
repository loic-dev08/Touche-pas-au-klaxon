<?php
declare(strict_types=1);

namespace App\Services;

/**
 * Class Validator
 * Validation des inputs (très simple, extensible).
 */
final class Validator {
    /**
     * @return array<string,string> erreurs par champ
     */
    public function validateTrip(array $data): array {
        $errrors =[];

        if (empty($data['depart_agency_id']) || empty($data['arrival_agency_id'])) {
            $errors['agencies'] = "Veuillez sélectionner les agences";
        } elseif ((int) $data ['depart_agency_id'] ===(int) $data['arrival_agency_id']) {
            $errors['agencies'] ="L'agence de départ et d'arrivée doivent être différentes";
        }
        $departAt = $data['depart_at'] ?? '';
        $arriveAt =$data['arrive_at'] ?? '';
        if (!$departAt || !$arriveAt) {
            $errors['dates'] = "Les dates de départ et d'arrivée sont obligatoires";
        }else {
            $d = strtotime($departAt);
            $a = strtotime($arriveAt);
            if ($d ===false || $a ===false) {
                $errors['dates'] = "Format de date invalide";
            }elseif ($a<=$d) {
                $errors['dates'] = "On ne peut pas arriver avant de partir";
            }
        }
        $total = (int)($data['seats_total'] ?? 0);
        if ($total <1 || $total > 8) {
            $errors['seats_total'] = "Le nombre total de places doit être entre 1 et 8";
        }
        return $errors;
    }
    /**
     * @return array<string,string>
     */
    public function validateAgency(array $data): array {
        $errors =[];
        $name =trim((string)($data['name'] ??''));

        if ($name ==='') {
            $errors['name'] = "Le nom de l'agence est obligatoire.";
        }elseif (mb_strlen($name)>80) {
            $errors['name'] = "Le nom de l'agence est trop long.";
        }
        return $errors;
    }
}
