<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Note::class);
    }

    // /**
    //  * @return Note[] Returns an array of Note objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Note
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByNotes($start, $count)
    {
        // Doit prendre les videos de $start sur un certain nombre
        //exemple: de 0 à 10 ou de 11 à 20 , voir fonction findByDates
        //Et les tier par nombre de vote ou par moyenne de vote
        //Cette fonction est appeler dans la function loadVideo du HomeController
        
        return $this->createQueryBuilder('n')
        ->orderBy('count(n.note)', 'DESC')
        ->groupBy('n.video')
        ->setFirstResult($start)
        ->setMaxResults($count)
        ->getQuery()
        ->getResult()
        ;


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
}
