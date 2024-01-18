<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Departement;
use App\Form\EmployeeType;

use App\Repository\EmployeeRepository;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee')]
class EmployeeController extends AbstractController
{
    #[Route('/', name: 'app_employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_show', methods: ['GET'])]
    public function show(Employee $employee, DepartementRepository $repos, EntityManagerInterface $entityManager): Response
    {
        $actualdep = $repos->findActualDepartment($employee);
        $employee->actualdep = $actualdep;
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
            // 'actualdep' => $actualdep
        ]);
    }


    #[Route('/controller/{id}', name: 'app_employee_show_controller', methods: ['GET'])]
    public function showControl(Employee $employee): Response

    {

        foreach ($employee->getDeptEmps() as $deptEmp) {
            //error_log("DeptEmp ToDate: " . $deptEmp->getToDate()->format('Y-m-d'));
            if ($deptEmp->getToDate()->format('Y-m-d') == '9999-01-01') {
                $employee->ctrl_actualDept = $deptEmp->getDepartement();
                break;
            }
        }

        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }
    #[Route('/repoquery/{id}', name: 'app_employee_show_repoquery', methods: ['GET'])]
    public function showRepoquery(Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Departement::class);

        $employee->repoqb_actualDept = $repository->findActualDepartment($employee);

        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_employee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $employee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
    }
}
