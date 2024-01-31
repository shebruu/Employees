<?php

namespace App\Controller;


use App\Entity\Employee;
use App\Entity\Departement;
use App\Form\EmployeeType;

use App\Entity\Project;

use App\Repository\EmployeeRepository;
use App\Repository\DepartementRepository;
use App\Repository\InternRepository;
use App\Repository\ProjectRepository;
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

    /**
     *
     * Affiche les détails d'un employé spécifique.
     * @param Employee $employee
     * @param DepartementRepository $repos
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}', name: 'app_employee_show', methods: ['GET'])]
    public function show(Employee $employee, DepartementRepository $repos, EntityManagerInterface $entityManager): Response
    {

        $actualdep = $repos->findActualDepartment($employee);

        //dd($actualdep);
        $employee->actualdep = $actualdep;
        //dd($employee);
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
            // 'actualdep' => $actualdep
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


    /**
     * Affiche la liste des stagiaires associés à un employé, ainsi que les stagiaires sans superviseur.
     *
     * @Route('/{id}/interns', name='app_intern_messtagiaires', methods=['GET'])
     * @param Employee $employee L'employé pour lequel la liste des stagiaires est affichée.
     * @param InternRepository $repo Le référentiel utilisé pour récupérer les informations sur les stagiaires.
     * @return Response La réponse qui affiche la liste d objet stagiaires de l employé et sans superviseur.
     */
    // concerne les employee et de leur interraction avec stagiaires
    #[Route('/{id}/interns', name: 'app_employee_affichemesstagiaires', methods: ['GET'])]
    public function Affichermesstagiaires(Employee $employee, InternRepository $repointern): Response
    {
        // Vérification de l'authentification de l'utilisateur
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Récupération des stagiaires (interns) ( et de leurs données) associés à l'employé
        $interns = $repointern->findMyActiveInternsOrWithoutSupervisor($employee);



        //dd($interns);

        return $this->render('employee/messtagiaires.html.twig', [

            'interns' => $interns,

        ]);
    }
    #[Route('/{id}/projects', name: 'app_employee_affichermesprojets', methods: ['GET'])]
    public function Affichermesprojets(Employee $employee, ProjectRepository $repo): Response
    {
        // Vérification de l'authentification de l'utilisateur
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $projectsWithEmployees = $repo->findAllProjectsWithEmployees();

        // dd($projectsWithEmployees);
        return $this->render('employee/mesprojets.html.twig', [
            'projectsWithemp' => $projectsWithEmployees,
        ]);
    }
}
