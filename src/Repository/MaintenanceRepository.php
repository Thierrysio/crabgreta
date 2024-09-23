<?php

namespace App\Repository;

use App\Entity\Maintenance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Maintenance>
 */
class MaintenanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maintenance::class);
    }

    //    /**
    //     * @return Maintenance[] Returns an array of Maintenance objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Maintenance
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getLibelleEmplacementParMaintenance(Maintenance $laMaintenance): array
{
    // Utilisation de QueryBuilder pour récupérer les libellés d'emplacement associés à une maintenance
    return $this->createQueryBuilder('m')
        ->select('s.LibelleEmplacement')
        ->join('m.lesTechniciens', 't')
        ->join('t.lesVisites', 'v')
        ->join('v.lesBornes', 'b')
        ->join('b.laStation', 's')
        ->where('m = :maintenance')
        ->setParameter('maintenance', $laMaintenance)
        ->getQuery()
        ->getResult();
}

public function getTBParMaintenance(Maintenance $laMaintenance): array
{
    // Utilisation de QueryBuilder pour récupérer les libellés d'emplacement associés à une maintenance
    return $this->createQueryBuilder('m')
        ->select('s.LibelleEmplacement')
        ->join('m.lesVisites', 'v')
        ->join('v.lesBornes', 'b')
        ->join('b.leTypeBorne', 'tb')
        ->where('m = :maintenance')
        ->setParameter('maintenance', $laMaintenance)
        ->getQuery()
        ->getResult();
}
}
