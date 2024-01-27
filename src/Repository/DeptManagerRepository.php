<?php

namespace App\Repository;

use App\Entity\DeptManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<DeptManager>
 *
 * @method DeptManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeptManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeptManager[]    findAll()
 * @method DeptManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeptManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeptManager::class);
    }

    public function findByDeptName(string $deptName)
    {
        /**
         * récupére tous les gestionnaires de département qui ont le meme 
         *  deptName  ayant le même nom de départemt
         */
        return $this->createQueryBuilder('dm')
            ->andWhere('dm.deptName = :deptName')
            ->setParameter('deptName', $deptName)
            ->getQuery()
            ->getResult();
    }

    /**
     * recupere les noms des managers et nomd de leur departement
     */
    public function findManagerNamesWithDepartments()
    {
        $qb = $this->createQueryBuilder('dm')
            ->join('dm.employee', 'e')
            ->join('dm.departement', 'd')
            ->select('e.firstName as firstName', 'd.dept_name as departmentName', 'd.id as departmentId');

        return $qb->getQuery()->getResult();
    }
    //    /**
    //     * @return DeptManager[] Returns an array of DeptManager objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DeptManager
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}
