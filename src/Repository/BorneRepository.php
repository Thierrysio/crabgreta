<?php

namespace App\Repository;

use App\Entity\Borne;
use App\Entity\Station;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Borne>
 */
class BorneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Appel au constructeur parent avec le ManagerRegistry
        parent::__construct($registry, Borne::class);
    }

    public function getLibelleEmplacementEtDureeRevisionParStation(Station $station): array
    {
        // Utilisation du QueryBuilder fourni par ServiceEntityRepository
        return $this->createQueryBuilder('b')
            ->select('s.LibelleEmplacement, tb.dureeRevision')
            ->join('b.laStation', 's')
            ->join('b.leTypeBorne', 'tb')
            ->where('s = :station')
            ->setParameter('station', $station)
            ->getQuery()
            ->getResult();
    }
}
