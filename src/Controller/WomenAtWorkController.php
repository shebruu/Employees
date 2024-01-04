<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



use Doctrine\ORM\EntityManagerInterface;

use App\Repository\EmployeeRepository;
use App\Repository\DepartmentRepository;
use App\Repository\DeptEmployeeRepository;


use App\Entity\Employee;
use App\Entity\Department;
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
    public function WomenSdepartment(EntityManagerInterface $entityManager): Response
    {


        $conn = $entityManager->getConnection();
        $sql = "
                SELECT d.dept_name AS departmentName, COUNT(e.emp_no) AS count
                FROM employees e
                INNER JOIN dept_emp  de ON e.emp_no = de.emp_no
                INNER JOIN departments d ON de.dept_no = d.dept_no
                WHERE e.gender = :gender
                GROUP BY d.dept_name
                ORDER BY count DESC
                LIMIT 3
            ";

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['gender' => 'F']);

        $topdepartments = $result->fetchAllAssociative();



        $sql = "
            SELECT d.dept_name AS departmentName, COUNT(e.emp_no) AS count
            FROM employees e
            INNER JOIN dept_emp  de ON e.emp_no = de.emp_no
            INNER JOIN departments d ON de.dept_no = d.dept_no
            WHERE e.gender = :gender
            GROUP BY d.dept_name
            ORDER BY count ASC
            LIMIT 3
        ";

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['gender' => 'H']);
        $bottomdepartments = $result->fetchAllAssociative();

        return $this->render('women_at_work/ml.html.twig', [

            'topdepartments' => $topdepartments,
            'bottomdepartments' => $bottomdepartments,
        ]);
    }
}
