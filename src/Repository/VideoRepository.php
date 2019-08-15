<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Video::class);
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    
    public function findByDates($start, $count)
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.date', 'DESC')
            ->setFirstResult($start)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    
    public function findByNotes(Video $video, $start, $count)
    {
        // Doit prendre les videos de $start sur un certain nombre
        //exemple: de 0 à 10 ou de 11 à 20 , voir fonction findByDates
        //Et les tier par nombre de vote ou par moyenne de vote
        //Cette fonction est appeler dans la function loadVideo du HomeController





        /*return $this->createQueryBuilder('v')
        //->select("*")
        //->from("video")
        //->setParameter('idvideo', 1)
        ->setParameter('videoNote', $video->getNotes())
        ->orderBy('count(videoNote)')
        ->getQuery()
        ->getResult()
    ;*/

    }
    

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
