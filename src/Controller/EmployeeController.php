<?php

namespace App\Controller;


use App\Entity\Employee;
use App\Entity\Departement;
use App\Form\EmployeeType;

use App\Entity\Project;

use App\Repository\GroupRepository;
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

    /**
     
     * Affiche une liste de tous les employés.
     * 
     * @param EmployeeRepository $employeeRepository
     * @return Response
     */
    #[Route('/', name: 'app_employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    /**
     * Crée un nouvel employé. Accessible uniquement par les administrateurs.
     * 
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
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
    public function show(Employee $employee, GroupRepository $groupRepo): Response
    {

        //$user = $this->getUser();
        $userId = $employee->getId();
        //Empêcher l'accès aux utilisateurs non connectés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //N'afficher que la fiche de l'utilisateur connecté
        if ($this->getUser() != $employee) {
            $this->addFlash('notice', 'Vous ne pouvez afficher que votre propre profil.');

            return $this->redirectToRoute('app_employee_show', ['id' => $userId], Response::HTTP_SEE_OTHER);
        }

        //Récupérer la liste des groupes non remplis
        $availableGroups = $groupRepo->findAvailableGroups();

        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
            'availableGroups' => $availableGroups,
        ]);
    }

    #[Route('/{id}', name: 'app_montrer', methods: ['GET'])]
    public function shows(Employee $employee): Response
    {
        return $this->render('employee/montrer.html.twig', [
            'employee' => $employee,
        ]);
    }

    /**
     *
     * Affiche les départements actuels d'un employé spécifique.
     * 
     * @param Employee $employee
     * @param DepartementRepository $repos
     * @return Response
     */
    #[Route('/{id}/controller', name: 'app_employee_show_controller', methods: ['GET'])]
    public function showControl(Employee $employee, DepartementRepository $repos): Response

    {
        /* exemple de récupération des departments actuels via getDepartment d entité employee
      
        $currentDepartments = [];
        //  pr ch instance de deptEmp ds employee, 
        foreach ($employee->getDeptEmps() as $deptEmp) {
            if ($deptEmp->getToDate()->format('Y-m-d') == '9999-01-01') {
                // $employee->ctrl_actualDept = $deptEmp->getDepartement();
                $currentDepartments[] = $deptEmp->getDepartement();    
            }
        }*/

        //récupere tous les départements de l' employé
        $employee->repoqb_actualDept = $repos->findAllDepartmentsForEmployee($employee);

        return $this->render('employee/show_controller.html.twig', [
            'employee' => $employee,
            /*  'currentDepartments' => $currentDepartments,*/
            'departments' => $employee->repoqb_actualDept,
        ]);
    }

    /** 
     *
     * Modifie un employé existant. Accessible uniquement par les administrateurs.
     * 
     * @param Request $request
     * @param Employee $employee
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

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

    /**
     * Supprime un employé. Accessible uniquement par les administrateurs.
     * 
     * @param Request $request
     * @param Employee $employee
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}', name: 'app_employee_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $employee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/join', name: 'app_employee_group_join', methods: ['POST'])]
    public function joinGroup(Request $request, Employee $employee, EntityManagerInterface $entityManager, GroupRepository $groupRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //Récupérer le groupe sélectionné dans le formulaire
        $groupCode = $request->get('groupCode');

        //Trouver le groupe
        $group = $groupRepo->find($groupCode);

        if ($group) {
            //S'inscrire au groupe sélectionné
            $employee->setGroup($group);

            //Persister dans la base de données
            $entityManager->flush();

            $this->addFlash('notice', 'Inscription effectuée.');
        } else {
            $this->addFlash('notice', 'Groupe introuvable. Inscription non effectuée!');
        }

        return $this->redirectToRoute('app_employee_show', ['id' => $employee->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/leave', name: 'app_employee_group_leave', methods: ['POST'])]
    public function leaveGroup(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        //Désinscrire du groupe
        $employee->setGroup(null);

        //Persister dans la base de données
        $entityManager->flush();

        $this->addFlash('notice', 'Désinscription effectuée.');

        return $this->redirectToRoute('app_employee_show', ['id' => $employee->getId()], Response::HTTP_SEE_OTHER);
    }
}
