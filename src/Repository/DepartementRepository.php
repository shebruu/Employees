<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\DeptEmp;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departement>
 *
 * @method Departement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departement[]    findAll()
 * @method Departement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departement::class);
    }

    /** 
     * @return Departement[] Returns an array of Departement objects
     */

    public function findActualDepartment($employee): ?Departement
    {
        // dd('ok');
        return $this->createQueryBuilder('d')
            ->select('d')
            ->innerJoin('d.deptEmps', 'de')
            ->innerJoin('de.employee', 'e') //correction
            ->where('e.id =:id')
            ->andwhere('de.to_date =:toDate') //correction 
            ->setParameter('id', $employee->getId())
            ->setParameter('toDate', '9999-01-01')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public  function findActualDepartmentemp($employee): ?Departement
    {
        return $this->createQueryBuilder('dept')
            ->select('d')
            ->from(Departement::class, 'd')
            ->innerJoin('d.deptEmps', 'de')
            ->innerJoin('de.employee', 'e')
            ->where('e.id = :id')
            ->andWhere('de.to_date = :toDate')
            ->setParameters([
                'id' => $employee->getId(),
                'toDate' => '9999-01-01'
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Departement[] Returns an array of Departement objects
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

    //    public function findOneBySomeField($value): ?Departement
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
