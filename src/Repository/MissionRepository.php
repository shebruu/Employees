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

    /**
     * Trouve les missions actives assignées à un employé spécifique.
     * 
     * Cette méthode récupère les missions qui sont actuellement actives (statut différent de 'terminé')
     * et assignées à l'employé passé en paramètre. Utilise une jointure pour lier les missions aux employés.
     *
     * @param Employee $employee Employé pour lequel trouver les missions actives.
     * @return array Mission[] Liste des missions actives assignées à cet employé.
     */
    public function findMissionsActifByEmployee(Employee $employee): array
    {
        return $this->createQueryBuilder('m')
            ->join('m.employees', 'e') // Jointure avec les employés assignés aux missions
            ->where('e.id= :employeeId') // Filtrage par ID de l'employé
            ->andWhere('m.status != :done') // Filtrage pour exclure les missions terminées
            ->setParameter('employeeId', $employee)
            ->setParameter('done', 'terminé')
            ->orderBy('m.id', 'ASC') //// Tri par ID de mission
            ->getQuery()
            ->getResult();
    }


    /**
     * Trouve les missions actives non assignées à un employé spécifique.
     * 
     * Cette méthode récupère les missions actives qui ne sont pas assignées à l'employé passé en paramètre.
     *
     * @param Employee $employee Employé à exclure des missions assignées.
     * @return array Mission[] Liste des missions actives non assignées à cet employé.
     */
    public function findMissionsNonAssigneesEtActives(Employee $employee): array
    {
        return $this->createQueryBuilder('miss')
            ->leftJoin('miss.employees', 'emp')
            ->where('miss.status != :done')
            ->andWhere(':employeeId NOT MEMBER OF miss.employees') // Exclusion des missions où l'employé est assigné
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
