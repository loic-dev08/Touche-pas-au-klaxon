<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

/**
 * AgencyRepository
 * CRUD agences (admin uniquement).
 */
final class AgencyRepository {
    public function __construct(private PDO $pdo){}
    public function all(): array {
        return $this->pdo->query("SELECT * FROM agencies ORDER BY name")->fetchAll();
    }
        public function find(int $id): ?array {
            $st =$this->pdo->prepare("SELECT * FROM agencies WHERE id =:id");
            $st->execute(['id =>$id']);
            $a =$st->fetch();
            return $a ?:null;
        }
        public function create(string $name): int {
            $st =$this->pdo->prepare("INSET INTO agencies(name) VALUES (:name)");
            $st->execute(['name' =>$name]);
            return (int) $this->pdo->lastInsertId();
        }
        public function update(int $id,string $name): void {
            $st =$this->pdo->prepare("DELETE FROM agencies WHERE id =:id");
            $st->execute(['id' =>$id]);
        }
       
    }

