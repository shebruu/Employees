<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



use Doctrine\ORM\EntityManagerInterface;

use App\Repository\EmployeeRepository;
use App\Repository\DepartementRepository;
use App\Repository\DeptEmployeeRepository;


use App\Entity\Employee;
use App\Entity\Departement;
use App\Entity\DeptEmployee;


/**
 * Contrôleur gérant les statistiques et informations liées à la représentation des femmes au travail.
 *
 * @Route("/women/at/work")
 */

#[Route('/women/at/work')]
class WomenAtWorkController extends AbstractController
{

    /**
     * Affiche les statistiques générales sur la répartition hommes/femmes.
     *
     * @param EmployeeRepository $employeeRepository Repository pour interagir avec les données des employés.
     * 
     * @return Response Renvoie la réponse pour le rendu de la vue.
     */
    #[Route('/', name: 'app_women_at_work_index', methods: ['GET'])]

    public function index(EmployeeRepository $employeeRepository): Response
    {
        // Calcul des statistiques sur le nombre d'hommes et de femmes.
        $nbFemmes = $employeeRepository->count(['gender' => 'F']);
        $nbHommes = $employeeRepository->count(['gender' => 'M']);

        // Calcul du total et des pourcentages.
        $total = $nbFemmes + $nbHommes;
        $pourcentageFemmes = $total > 0 ? ($nbFemmes / $total * 100) : 0;
        $pourcentageHommes = $total > 0 ? ($nbHommes / $total * 100) : 0;
        return $this->render('women_at_work/index.html.twig', [
            'pourcentageFemmes' => $pourcentageFemmes,
            'pourcentageHommes' => $pourcentageHommes,


        ]);
    }
    /**
     * Affiche des statistiques détaillées sur la représentation des femmes dans différents départements.
     *
     * @param EntityManagerInterface $entityManager Gestionnaire d'entité pour interagir avec la base de données.
     * 
     * @return Response Renvoie la réponse pour le rendu de la vue.
     */
    #[Route('/ml', name: 'app_women_at_work_ml', methods: ['GET'])]

    public function womenAtWork(EntityManagerInterface $entityManager): Response
    {
        // Récupération des données des départements.
        $departementRepository = $entityManager->getRepository(Departement::class);

        $topFemaleDepartments = $departementRepository->findDepartementsByGender('F', 'DESC');
        $bottomFemaleDepartments = $departementRepository->findDepartementsByGender('F', 'ASC');

        return $this->render('women_at_work/ml.html.twig', [
            'topFemaleDepartments' => $topFemaleDepartments,
            'bottomFemaleDepartments' => $bottomFemaleDepartments,
        ]);
    }
}
