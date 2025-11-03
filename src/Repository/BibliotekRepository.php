<?php

namespace App\Repository;

use App\Entity\Bibliotek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bibliotek>
 */
class BibliotekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bibliotek::class);
    }

// TAGEN FRÅN ÖVNINGEN - MODIFIERA FÖR UPDATE

    /**
     * Update book based on ID.
     * 
     * @return [][] Returns an array of arrays (i.e. a raw data set)
     */
    public function findByMinimumValue2($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            UPDATE tabellnamn
            SET kolumn1 = nytt_värde1,
                kolumn2 = nytt_värde2,
                ...
            WHERE id = $id
        ';

        $resultSet = $conn->executeQuery($sql, ['value' => $value]);

        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Bibliotek[] Returns an array of Bibliotek objects
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

    //    public function findOneBySomeField($value): ?Bibliotek
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
