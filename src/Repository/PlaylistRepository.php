<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Playlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playlist[]    findAll()
 * @method Playlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function addtoplaylist($id, $idplaylist)
    {
        //ajoute l'id du mp3 à la playliste de l'utilisateru par son id

        return $this->createQueryBuilder("p")
            ->select('p')
            ->join('c.mailseconds', 'cm')
            ->addSelect('cm')
            ->where('cm.client = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Playlist[] Returns an array of Playlist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Playlist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $plmusic
     * @param $member
     * @param $mfid
     * @return mixed
     */
    public function findMusicInPlayliste($plmusic, $member, $mfid)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :plmusic')
            ->andWhere('p.member = :member')
            ->join('p.musicfile', 'mf')
            ->addSelect('mf')
            ->andWhere('mf.id = :mfid')
            ->setParameter('plmusic', $plmusic)
            ->setParameter('member', $member)
            ->setParameter('mfid', $mfid)
            ->getQuery()
            ->getResult();
    }
}
