<?php

namespace App\Repository;

use App\Entity\Borne;
use App\Entity\Station;
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

    //    /**
    //     * @return Borne[] Returns an array of Borne objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Borne
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getLibelleEmplacementEtDureeRevisionParStation(Station $station): array
    {
        $query = $this->entityManager->createQuery(
            'SELECT s.LibelleEmplacement, tb.dureeRevision 
             FROM Borne b
             JOIN b.laStation s
             JOIN b.leTypeBorne tb
             WHERE s = :station'
        )->setParameter('station', $station);

        return $query->getResult();
    }
}
