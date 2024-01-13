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

#[Route('/women/at/work')]
class WomenAtWorkController extends AbstractController
{

    #[Route('/', name: 'app_women_at_work_index', methods: ['GET'])]
    //acces au repository pour recuperer depuis la bd : point d entree princ
    public function index(EmployeeRepository $employeeRepository): Response
    {
        $nbFemmes = $employeeRepository->count(['gender' => 'F']);
        $nbHommes = $employeeRepository->count(['gender' => 'M']);


        $total = $nbFemmes + $nbHommes;
        $pourcentageFemmes = $total > 0 ? ($nbFemmes / $total * 100) : 0;
        $pourcentageHommes = $total > 0 ? ($nbHommes / $total * 100) : 0;
        return $this->render('women_at_work/index.html.twig', [
            'pourcentageFemmes' => $pourcentageFemmes,
            'pourcentageHommes' => $pourcentageHommes,


        ]);
    }

    #[Route('/ml', name: 'app_women_at_work_ml', methods: ['GET'])]
    public function womenAtWork(EntityManagerInterface $entityManager): Response
    {
        $departementRepository = $entityManager->getRepository(Departement::class);

        $topFemaleDepartments = $departementRepository->findDepartementsByGender('F', 'DESC');
        $bottomFemaleDepartments = $departementRepository->findDepartementsByGender('F', 'ASC');

        return $this->render('women_at_work/ml.html.twig', [
            'topFemaleDepartments' => $topFemaleDepartments,
            'bottomFemaleDepartments' => $bottomFemaleDepartments,
        ]);
    }
}
