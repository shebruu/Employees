<?php

namespace App\Controller;

use App\Entity\Project;

use App\Entity\Employee;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }

    /*

    #[Route('/{id}/supprimer', name: 'app_projet_supprimer', methods: ['POST'])]
    public function supprimEmployee(
        Employee $employee,
        Request $request,
        Project $projet,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();


        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // Remove the employee from the project


        $projet->removeEmployee($employee);


        $em->persist($projet);
        // Persist the changes to the database
        $em->flush();

        if ($projet->getEmployees()) {
            $this->addFlash('notice', 'Succès');
        } else {
            $this->addFlash('notice', 'Erreur');
        }


        // redirige l'utilisateur vers la page d'affichage des stagiaires. (employee/id/projects)
        return $this->redirectToRoute(
            'app_employee_affichemesprojets',
            ['id' => $user],
            Response::HTTP_SEE_OTHER
        );
    }*/


    /**
     * retirer un employé d' un projet donnt on est chef de projet 
     */

    #[Route('/{id}/supprimer', name: 'app_projet_supprimer', methods: ['POST'])]
    public function supprimEmployee(
        Request $request,
        EntityManagerInterface $entityManager,

    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Get the employee ID from the request
        $employeeId = $request->request->get('employee.id');

        if (!$employeeId) {
            // Handle the case where employee_id is not provided in the request
            $this->addFlash('error', 'Employee ID not provided in the request.');
            return $this->redirectToRoute('app_employee_affichermesprojets');
        }

        // Find the employee by ID
        $employee = $entityManager->getRepository(Employee::class)->find($employeeId);

        if (!$employee) {
            // Handle the case where the employee is not found
            $this->addFlash('error', 'Employee not found.');
            return $this->redirectToRoute('app_employee_affichermesprojets');
        }

        // Remove the employee from the project (assuming you have a method like removeEmployee in Project entity)
        $project = $employee->getProject();
        if ($project) {
            $project->removeEmployee($employee);
            $entityManager->persist($project);
        }

        // Persist the changes to the database
        $entityManager->flush();

        $this->addFlash('success', 'Employee removed from the project successfully.');

        // Redirect the user back to the project list
        return $this->redirectToRoute('app_employee_affichermesprojets');
    }
}
