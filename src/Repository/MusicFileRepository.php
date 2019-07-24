<?php

namespace App\Repository;

use App\Entity\MusicFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MusicFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicFile[]    findAll()
 * @method MusicFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MusicFile::class);
    }

    public function findRecent()
    {
        return $this->createQueryBuilder("a")
            ->select('a')
            ->orderBy('a.filetransfertdate', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return MusicFile[] Returns an array of MusicFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MusicFile
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
