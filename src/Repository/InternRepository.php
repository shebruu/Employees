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

    /**
     *  récupère les stagiaires qui sont supervisés par un employé spécifié
     *
     * @param Employee $employee L'employé pour lequel la liste des stagiaires est recherchée.
     * @return array interns [] Un tableau contenant les stagiaires associés à l'employé.
     */

    public function findMesstagiaires($employee): array
    {
        return $this->createQueryBuilder('m')

            ->join('m.superviseur', 'e')
            //( )Filtre pour correspondre à l'employé spécifié
            ->where('e = :employee')
            // Filtre pour critere de date date
            ->andWhere('m.endDate > :today')
            // Définition du paramètre 'employee' 
            ->setParameter('employee', $employee)

            ->setParameter('today', new \DateTime())
            ->getQuery()
            // Exécution de la Query et récupération du résultat
            ->getResult();
    }

    /**
     * récupère les stagiaires qui n'ont pas de superviseur 
     *
     * @return array interns[] retourne Un tableau contenant les stagiaires sans superviseur.
     */
    public function findStagiairesSanssuperviseur($employee): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.superviseur IS NULL')

            ->getQuery()
            ->getResult();
    }

    /** + simple mais ne retourne que ssup
     *  récupère les stagiaires qui sont supervisés par un employé spécifié et dont la date de fin (endDate) est postérieure à la date actuelle.
     * ou les stagiaires qui n'ont pas de superviseur
     * @return Intern[] idem
     */
    public function findMyActiveInternsOrWithoutSupervisor($employee): array
    {
        return $this->createQueryBuilder('i')
            ->where('i.endDate < :today')
            ->andWhere('i.superviseur = :superviseur')
            ->orWhere('i.superviseur IS NULL')
            ->setParameters([
                'today' => new \DateTime(),
                'superviseur' => $employee->getId()
            ])
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
