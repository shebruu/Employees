<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\Employee;
use App\Entity\DeptEmp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\ArrayType;
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
     * Récupère la liste des départements avec des stagiaires et les trie par superviseur décroissant.
     *
     * @return array Un tableau contenant les départements avec des stagiaires triés par superviseur décroissant.
     */
    public function finDepartmentsWithInterns(): array
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.interns', 'i')
            ->groupBy('d')
            ->orderBy('i.superviseur', 'DESC')
            ->getQuery()
            ->getResult();
    }



    /**
     * Trouve les départements par genre avec un ordre et une limite spécifiés.
     * Utilisé dans 'app_women_at_work_ml'.
     *
     * @param string $gender Genre à filtrer ('F', ou 'H')
     * @param string $order Ordre de tri.
     * @param int $limit Nombre maximal de résultats à retourner.
     * 
     * @return array Résultats de la requête.
     */
    public function findDepartementsByGender($gender, $order = 'DESC', $limit = 3)
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d.dept_name, COUNT(e.id) as count')
            ->innerJoin('d.deptEmps', 'de')
            ->innerJoin('de.employee', 'e')
            ->where('e.gender = :gender')
            ->setParameter('gender', $gender)
            ->groupBy('d.id')
            ->orderBy('count', $order)
            ->setMaxResults($limit);

        // dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }


    /**
     * Trouve le département actuel d'un employé.
     * Utilisé dans 'app_employee_show' et 'app_employee_show_repoquery'.
     *
     * @param Employee $employee Employé pour lequel trouver le département.
     * 
     * @return Departement|null Le département actuel de l'employé ou null si non trouvé.
     */

    public function findActualDepartment($employee): ?Departement
    {
        // dd('ok');
        return $this->createQueryBuilder('d')
            ->innerJoin('d.deptEmps', 'de')
            ->innerJoin('de.employee', 'e')
            ->where('e.id =:id')
            ->andwhere('de.to_date =:toDate')
            ->setParameter('id', $employee->getId())
            ->setParameter('toDate', '9999-01-01')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /*  ou 
    return $this->createQueryBuilder('d')
        ->innerJoin('d.deptEmps', 'de')
        ->where('de.employee = :employee')
         ->setParameter('employee', $employee)
      au lieu de passer par 
            ->innerJoin('de.employee', 'e')
            ->where('e.id =:id')
            ->setParameter('id', $employee->getId())
     */



    /**
     * Récupère tous les départements associés à un employé.
     * 
     * @param Employee $employee Employé pour lequel récupérer les départements.
     * 
     * @return array  Departement[] Liste de tous les départements associés à l'employé.
     */
    public function findAllDepartmentsForEmployee($employee): array
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.deptEmps', 'de')
            ->where('de.employee = :employee')
            ->andWhere('de.to_date = :toDate')
            ->setParameter('employee', $employee)
            ->setParameter('toDate', '9999-01-01')
            ->getQuery()
            ->getResult(); // pour obtenir une liste de résultats
    }
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
