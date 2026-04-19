<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Repositories\TripRepository;
use PDO;
use Throwable;

final class TripWriteTest extends TestCase
{
    private PDO $pdo;
    private TripRepository $repo;
    /** @var int[] */
    private array $createdIds = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = testPdo();
        $this->repo = new TripRepository($this->pdo);
    }

    protected function tearDown(): void
    {
        foreach ($this->createdIds as $id) {
            try {
                $this->repo->delete($id);
            } catch (Throwable $e) {
                // ignore cleanup errors
            }
        }
        $this->createdIds = [];
        parent::tearDown();
    }

    public function testCreateTrip(): void
    {
        // Pré‑requis minimal : 1 user + 2 agencies (on suppose seed sur DB test)
        $userid = (int) $this->pdo->query("SELECT id FROM users LIMIT 1")->fetchColumn();
        $ag1 = (int) $this->pdo->query("SELECT id FROM agencies LIMIT 1")->fetchColumn();
        $ag2 = (int) $this->pdo->query("SELECT id FROM agencies ORDER BY id DESC LIMIT 1")->fetchColumn();

        $this->assertGreaterThan(0, $userid, 'Aucun utilisateur trouvé dans la base de test.');
        $this->assertGreaterThan(0, $ag1, 'Aucune agence (1) trouvée dans la base de test.');
        $this->assertGreaterThan(0, $ag2, 'Aucune agence (2) trouvée dans la base de test.');
        $this->assertNotSame($ag1, $ag2, 'Les deux agences doivent être différentes pour le test.');

        $id = $this->repo->create([
            'depart_agency_id'   => $ag1,
            'arrival_agency_id'  => $ag2,
            'depart_at'          => date('Y-m-d H:i:s', time() + 3600),
            'arrival_at'         => date('Y-m-d H:i:s', time() + 7200),
            'seats_total'        => 3,
            'seats_available'    => 3,
            'contact_user_id'    => $userid,
            'author_user_id'     => $userid,
        ]);

        $this->assertIsInt($id, 'create() doit retourner l\'ID (int) du trajet.');
        $this->assertGreaterThan(0, $id, 'L\'ID retourné doit être supérieur à 0.');

        // Enregistrer pour le nettoyage
        $this->createdIds[] = $id;

        // Vérifier que le trajet existe après création
        $trip = $this->repo->find($id);
        $this->assertNotNull($trip, 'Le trajet créé doit être trouvable via find().');

        // Vérifications basiques des champs (si l'objet retourné expose les getters)
        if (is_object($trip)) {
            if (method_exists($trip, 'getDepartAgencyId')) {
                $this->assertSame($ag1, (int) $trip->getDepartAgencyId());
            }
            if (method_exists($trip, 'getArrivalAgencyId')) {
                $this->assertSame($ag2, (int) $trip->getArrivalAgencyId());
            }
            if (method_exists($trip, 'getSeatsTotal')) {
                $this->assertSame(3, (int) $trip->getSeatsTotal());
            }
        }
    }
}
