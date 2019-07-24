<?php

namespace App\Repository;

use App\Entity\PlaylistProject;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method PlaylistProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaylistProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaylistProject[]    findAll()
 * @method PlaylistProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlaylistProject::class);
    }


    public function findByLatestProject()
    {

        return $this->createQueryBuilder('p')
            ->join('p.artistbandplproject', 'ab', 'ab.id = p.artistbandplproject')
            ->addSelect('p.artistbandplproject', 'COUNT(p) as nb')
            ->groupBy('ab.artistbandname')
            ->orderBy('nb', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findMonthlyProjects($date)
    {
        return $this->createQueryBuilder('p')
            ->join('p.artistbandplproject', 'ab', 'ab.id = p.artistbandplproject')
            ->where('p.dateCreated BETWEEN :date AND :now')
            ->orderBy('p.id', 'DESC')
            ->setParameter('date', $date)
            ->setParameter('now', new DateTime('now'))
            ->getQuery()
            ->getResult();
    }
}
