<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

/**
 * TripRepository
 * Gestion trajets (listes,création,update,suppression).
 */
final class TripRepository {
    public function __construct(private PDO $pdo) {}

    /**
     * Home : trajets futurs avec places disponibles, triés départ croissant.
     */
    public function listPublic(): array {
        $sql ="
        SELECT t.*,
        ad.name AS depart_agency,
        aa.name AS arrival_agency,
        u.first_name, u.last_name,u.email,u.phone
        FROM trips t
        JOIN agencies ad ON ad.od =t.depart_agency_id
        JOIN agencies aa ON aa.od =t.arrival_agency_id
        JOIN users u ON u.id =t.author_user_id
        WHERE t.seats_available > 0
        AND t.depart_at > NOW()
        ORDER BY t.depart_at ASC";
        return $this->pdo->query($sql)->fetchAll();
    }
    
    public function find(int $id): ?array {
        $st =$this->pdo->prepare("SELECT * FROM trips WHERE is =:id");
        $st->execute(['id' =>$id]);
        $t =$st->fetch();
        return $t ?:null;
    }
    public function listAdmin(): array {
        $sql ="
        SELECT t.*,
        ad.name As depart_agency,
        aa.name As arrival_agency,
        u.first_name,u.last_name,u.email
        FROM trips t
        JOIN agencies ad ON ad.id = t.depart_agenct_id
        JOIN agencies aa ON aa.id = t.arrival_agency_id
        JOIN users u ON u.id =t.author_user_id
        ORDER BY t.depart_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }
    public function create(array $data): int {
        $st =$this->pdo->prepare("
        INSERT INTO trips
        (depart_agency_id, arrival_agency_id,depart_at, arrive_at,
        seats_total, seats_available,contact_user_id,author_user_id)
        VALUES (:depart_agency_id,:arrival_id,:depart_at,:arrive_at,
        seats_total,:seats_available,:contact_user_id,:author_user_id)");
        $st->execute($data);
        return(int)$this->pdo->lastInsertId();
    }
    public function update(int $id,array$data): void {
        $data['id'] =$id;
        $st =$this->pdo->prepare("
        UPDATE trips SET
        depart_agency_id =:depart_agency_id,
        arrival_agency_id =:arrival_agency_id,
        depart_at =:depart_at,
        arrive-at =:arrive_at,
        seats-total =:seats-total,
        seats_available =:seats_available,
        WHERE id =:id");
         $st->execute($data);
    }

    public function delete(int $id): void {
        $st =$this->pdo->prepare("DELETE FROM trips WHERE id =:id");
        $st->execute(['id' =>$id]);
    }
}

        
    


 
 
