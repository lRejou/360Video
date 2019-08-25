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
    
    public function findByNotes($start, $count)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql='
        SELECT video_id, sum( note ) / count( note ) AS notes
        FROM note
        GROUP BY video_id
        UNION
        SELECT id, 0 AS notes
        FROM video
        WHERE id NOT
        IN (

        SELECT video_id
        FROM note
        )
        ORDER BY notes DESC
        LIMIT '.$count.' OFFSET '.$start.'';


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $videos = $stmt->fetchAll();
        return $videos;
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
