<?php
declare(strict_types=1);

namespace App\Tests\Trip;

use PHPUnit\Framework\TestCase;
use App\Repositories\AgencyRepository;
use PDO;
use Throwable;

final class AgencyWriteTest extends TestCase
{
    private PDO $pdo;
    private AgencyRepository $repo;
    /** @var int[] */
    private array $createdIds = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = \testPdo(); // appel à la fonction globale depuis un namespace
        $this->repo = new AgencyRepository($this->pdo);
    }

    protected function tearDown(): void
    {
        foreach ($this->createdIds as $id) {
            try {
                $this->repo->delete($id);
            } catch (Throwable $e) {
                // ignorer les erreurs de nettoyage
            }
        }
        $this->createdIds = [];
        parent::tearDown();
    }

    public function testCreateUpdateDeleteAgency(): void
    {
        // CREATE
        $created = $this->repo->create('Test Agency_' . uniqid('', true));
        $this->assertNotNull($created, 'create() a retourné null.');

        // Accepter soit un objet avec getId(), soit un int ID
        if (is_object($created) && method_exists($created, 'getId')) {
            $id = (int) $created->getId();
        } elseif (is_int($created)) {
            $id = $created;
        } else {
            $this->fail('create() doit retourner un objet avec getId() ou un entier ID.');
        }

        $this->assertGreaterThan(0, $id, 'L\'ID doit être supérieur à 0.');
        $this->createdIds[] = $id;

        // UPDATE
        $updatedName = 'TestAgencyUpdated_' . uniqid('', true);
        $this->repo->update($id, $updatedName);

        // Récupérer l'agence : essayer findById() puis find()
        $agency = null;
        if (method_exists($this->repo, 'findById')) {
            $agency = $this->repo->findById($id);
        } elseif (method_exists($this->repo, 'find')) {
            $agency = $this->repo->find($id);
        }

        $this->assertNotNull($agency, 'L\'agence mise à jour est introuvable.');

        if (is_object($agency) && method_exists($agency, 'getName')) {
            $this->assertSame($updatedName, $agency->getName(), 'Le nom de l\'agence n\'a pas été mis à jour.');
        }

        // DELETE
        $this->repo->delete($id);

        // Vérifier la suppression (findById() ou find() peut retourner null/false)
        $foundAfterDelete = null;
        if (method_exists($this->repo, 'findById')) {
            $foundAfterDelete = $this->repo->findById($id);
        } elseif (method_exists($this->repo, 'find')) {
            $foundAfterDelete = $this->repo->find($id);
        }

        $this->assertTrue($foundAfterDelete === null || $foundAfterDelete === false, 'L\'agence devrait être supprimée.');

        // retirer de la liste de nettoyage si déjà supprimée
        $this->createdIds = array_values(array_filter($this->createdIds, fn($v) => $v !== $id));
    }
}
