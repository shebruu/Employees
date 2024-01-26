<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * Persiste l'entité Employee dans la base de données.
     *
     * @param Employee $entity L'entité Employee à persister.
     * @param bool $flush Si vrai, effectue un flush immédiatement après la persistance.
     */
    public function save(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime l'entité Employee de la base de données.
     *
     * @param Employee $entity L'entité Employee à supprimer.
     * @param bool $flush Si vrai, effectue un flush immédiatement après la suppression.
     */
    public function remove(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * Récupère un tableau d'objets Employee qui n'ont pas de stagiaires associés.
     *
     * @return Employee[] Un tableau d'objets Employee sans stagiaires associés.
     */
    public function findEmployeesWithNoIntern(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.interns is empty')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function getEmployeeCountByDepartment()
    {
        return $this->createQueryBuilder('e')
            ->select('d.name as departmentName, e.gender, COUNT(e) as count')
            ->join('e.department', 'd')
            ->groupBy('d.name', 'e.gender')
            ->getQuery()
            ->getResult();
    }*/
    //    /**
    //     * @return Employee[] Returns an array of Employee objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Employee
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
