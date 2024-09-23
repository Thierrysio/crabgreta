<?php

namespace App\Repository;

use App\Entity\Station;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Station>
 */
class StationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appel au constructeur parent avec le ManagerRegistry
        parent::__construct($registry, Station::class);
    }

    public function getLibelleEmplacement(Station $station): array
    {
        // Utilisation du QueryBuilder fourni par ServiceEntityRepository
        $query = $this->createQueryBuilder('s')
            ->select('s.LibelleEmplacement')
            ->where('s = :station')
            ->setParameter('station', $station)
            ->getQuery();

        return $query->getResult();
    }
}
