<?php

namespace App\Repository;

use App\Entity\Topic;
use App\Entity\SubTopic;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method SubTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubTopic[]    findAll()
 * @method SubTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubTopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubTopic::class);
    }

    // /**
    //  * @return SubTopic[] Returns an array of SubTopic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubTopic
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllByTopic(Topic $t): ?SubTopic
    {
        $db = $this->createQueryBuilder('s')
            ->andWhere('s.idTopic = :val')
            ->setParameter('val', $t->getId());

        $array = $db->getQuery()->getArrayResult();

        return $array;
    }
    
    public function countByTopic(Topic $t): ?SubTopic
    {
        $db = $this->createQueryBuilder('s')
            ->andWhere('s.idTopic = :val')
            ->setParameter('val', $t->getId())
            ->select('count(s.id');

        $query = $db->getQuery();
        
        return $query->getOneOrNullResult();
    }
}
