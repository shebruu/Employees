<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }


    public function findAllProjectsWithEmployees()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.employees', 'e')
            ->addSelect('e')
            ->getQuery()
            ->getResult();
    }


    /**
     * Récupère les projets avec des détails sur le chef de projet et les employés associés.
     * 
     *
     * @return array Liste des projets avec les détails des chefs de projet et des employés associés.
     */
    /*
    public function findProjetsWithDetails()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.chefDeProjet', 'chef') 
            ->addSelect('chef')
            ->leftJoin('p.employees', 'e')
            ->addSelect('e')
            ->getQuery()
            ->getResult();
    } TODO
    */


    //    /**
    //     * @return Project[] Returns an array of Project objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Project
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
