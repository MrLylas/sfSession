<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    // public function findTraineeNotInSession(){
        
    //     $entityManager = $this->getEntityManager();
    //     $query = $entityManager->createQuery(
    //         'SELECT t
    //         FROM App\Entity\Trainee t
    //         WHERE t.id NOT IN (
    //             SELECT s.trainee
    //             FROM App\Entity\Session s
    //         )'
    //     );
    //     $query->execute();

    //     return $query->getResult();
    // }

    public function findTraineeNotInSession($session_id){

        $entityManager = $this->getEntityManager();
        $subQuery = $entityManager->createQueryBuilder();

        $qb = $subQuery;

        $qb->select('t');
        $qb->from('App\Entity\Trainee', 't');
        $qb->leftJoin('t.sessions', 's');
        $qb->where('s.id = :id');

        $subQuery = $entityManager->createQueryBuilder();

        $subQuery->select('tr');
        $subQuery->from('App\Entity\Trainee', 'tr');
        $subQuery->where($qb->expr()->notIn('tr.id', $qb->getDQL()));
        $subQuery->setParameter('id', $session_id);
        $subQuery->orderBy('tr.lastName');

        $query = $subQuery->getQuery();

        return $query->getResult();
    }
}
