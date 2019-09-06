<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    // /**
    //  * @return Note[] Returns an array of Note objects
    //  */

    public function findByIdConference($value)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u')
            // selects all the category data to avoid the query
            ->addSelect('u')
            ->andWhere('n.conference = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function findAllArray()
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u')
            ->innerJoin('n.conference', 'c')
            // selects all the category data to avoid the query
            ->addSelect('u','c')
            ->getQuery()
            ->getArrayResult()
            ;
    }




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
}
