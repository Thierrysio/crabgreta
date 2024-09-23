<?php

namespace App\Repository;

use App\Entity\Borne;
use App\Entity\Station;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borne>
 */
class BorneRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getLibelleEmplacementEtDureeRevisionParStation(Station $station): array
    {
        $query = $this->entityManager->createQuery(
            'SELECT s.LibelleEmplacement, tb.dureeRevision 
             FROM App\Entity\Borne b
             JOIN b.laStation s
             JOIN b.leTypeBorne tb
             WHERE s = :station'
        )->setParameter('station', $station);

        return $query->getResult();
    }
}
