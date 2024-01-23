<?php

namespace App\Repository;

use App\Entity\Intern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intern>
 *
 * @method Intern|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intern|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intern[]    findAll()
 * @method Intern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intern::class);
    }
    public function findMesstagiaires($employee): array
    {
        return $this->createQueryBuilder('m')

            ->join('m.empNo', 'e')
            //(nom de propriete ds intern )Filtre pour correspondre à l'employé spécifié
            ->where('e = :employee')
            // Filtre pour choisir les stagiaires dont le la date  n' est pas depassé
            ->andWhere('m.startDate != :date')
            // Définition du paramètre 'employee' 
            ->setParameter('employee', $employee)
            // Définition du paramètre 'date' pour la clause AND WHERE
            ->setParameter('date', '9999-09-09')
            // Obtention de la Query
            ->getQuery()
            // Exécution de la Query et récupération du résultat
            ->getResult();
    }


    public function findStagiairesSanssuperviseur($employee): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.empNo IS NULL')

            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Intern[] Returns an array of Intern objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Intern
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
