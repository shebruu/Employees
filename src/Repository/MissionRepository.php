<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employee;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    //récupérer les missions actif ( statut pas terminé ) de l' employé (qui lui sont assigné )
    public function findMissionsActifByEmployee(Employee $employee): array
    {
        return $this->createQueryBuilder('miss')
            ->join('miss.employees', 'emp') // preferer a select pr relationner manytomany ( collection employees ds Missions.php)
            ->where('emp.id= :employeeId') // :employee (variable de  holderplace)  pour setparameter
            ->andWhere('miss.status != :done')
            ->setParameter('employeeId', $employee)
            ->setParameter('done', 'terminé')
            ->orderBy('miss.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findMissionsNonAssigneesEtActives(Employee $employee): array
    {
        return $this->createQueryBuilder('miss')
            ->leftJoin('miss.employees', 'emp')
            ->where('miss.status != :done')
            ->andWhere(':employeeId NOT MEMBER OF miss.employees') // S'assurer que l'employé n est pas assigné a la mission
            ->setParameter('employeeId', $employee)
            ->setParameter('done', 'terminé')
            ->orderBy('miss.id', 'ASC') // Trier par id
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Mission[] Returns an array of Mission objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Mission
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
