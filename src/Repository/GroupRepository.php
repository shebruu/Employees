<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

   /**
    * @return Group[] Returns an array of Group objects
    */
   public function findAvailableGroups(): array
   {   
       return $this->createQueryBuilder('g')
            ->select('g.code, g.name, g.maxSize, count(e.id) as total')
            ->leftJoin('g.employees','e')
            ->groupBy('g.code')
            ->having('total < g.maxSize')
            ->getQuery()
            ->getResult()
       ;
    
    /*  $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT groups.*, COUNT(members.emp_no) AS total FROM `groups`
        LEFT JOIN `members` ON groups.code=members.group_code 
        GROUP BY groups.code HAVING total < max_size;
            ';

        $resultSet = $conn->executeQuery($sql, []);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    */
   }

//    /**
//     * @return Group[] Returns an array of Group objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Group
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
