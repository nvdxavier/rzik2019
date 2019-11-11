<?php

namespace App\Repository;

use App\Entity\ArtistBand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ArtistBand|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistBand|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistBand[]    findAll()
 * @method ArtistBand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistBandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ArtistBand::class);
    }

    /**
     * @param $cityname
     * @return mixed
     */
    public function findCityLike($cityname)
    {
        return $this->createQueryBuilder('ab')
            ->select('ab.artistband_city')
            ->where('LOWER(ab.artistband_city) LIKE :cityname')
            ->setParameter('cityname', '%' . strtolower($cityname) . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     */
    public function findByLatestProject()
    {
        return $this->createQueryBuilder('ab')
            ->select('ab')
            ->join('ab.artistbandproject', 'project')
            ->addSelect('project')
            ->orderBy('project.datecreateplproject', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
