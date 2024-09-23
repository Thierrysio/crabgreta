<?php

namespace App\Repository;

use App\Entity\Borne;
use App\Entity\Station;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borne>
 */
class BorneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borne::class);
    }

    public function getLibelleEmplacementEtDureeRevisionParStation(Station $station,EntityManagerInterface $entityManager): array
    {
        $query = $entityManager->createQuery(
            'SELECT s.LibelleEmplacement, tb.dureeRevision 
             FROM Borne b
             JOIN b.laStation s
             JOIN b.leTypeBorne tb
             WHERE s = :station'
        )->setParameter('station', $station);

        return $query->getResult();
    }
}
