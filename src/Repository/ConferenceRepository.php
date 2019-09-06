<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    // /**
    //  * @return Conference[] Returns an array of Conference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findAllC()
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.user', 'u')
            ->addSelect('u')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
            ;
    }
    public function findAllNotVoted($iduser)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.notes', 'n')
            ->join('n.user','u')
            ->andWhere('u.id != :val')
            ->setParameter('val', $iduser)
            ->getQuery()
            ->getArrayResult()
            ;
    }
    public function findAllNotVotedBIS($iduser)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.notes', 'n')
            ->join('n.user','u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $iduser)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function findVotedC($eval)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.eval = :val')
            ->setParameter('val', $eval)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function search($name)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name LIKE :val')
            ->setParameter('val', '%'.$name.'%')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Conference
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
