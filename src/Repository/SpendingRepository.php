<?php

namespace App\Repository;

use App\Entity\Spending;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Spending|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spending|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spending[]    findAll()
 * @method Spending[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpendingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spending::class);
    }

    public function getData($type,$cat,$month){
        return $this->createQueryBuilder('s')
        ->where('s.type = :type')
        ->andWhere('s.category = :category')
        ->andWhere('s.month = :month')
        ->setParameter('type',$type)
        ->setParameter('month',$month)
        ->setParameter('category',$cat)
        ->getQuery()
        ->getResult();
    }

    public function getDataByMonth($month){
        return $this->createQueryBuilder('s')
        ->where('s.month = :month')
        ->setParameter('month',$month)
        ->getQuery()
        ->getResult();
    }

    public function getDataByDay($day,$type){
        return $this->createQueryBuilder('s')
        ->where('s.date = :day')
        ->andWhere('s.type = :type')
        ->setParameter('day',$day)
        ->setParameter('type',$type)
        ->getQuery()
        ->getResult();
    }
    // /**
    //  * @return Spending[] Returns an array of Spending objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Spending
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
