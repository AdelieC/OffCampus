<?php

namespace App\Repository;

use App\Entity\OutingImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OutingImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutingImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutingImage[]    findAll()
 * @method OutingImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutingImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutingImage::class);
    }

    // /**
    //  * @return OutingImage[] Returns an array of OutingImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OutingImage
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
