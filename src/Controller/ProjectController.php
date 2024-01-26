<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;

use App\Entity\Employee;
use App\Repository\ProjectRepository;

#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    public function index(ProjectRepository $projectrepository): Response
    {
        $projectrepost = 3;

        return $this->render('project/index.html.twig', [
            'projects' => $projectrepost,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_projet_supprimer', methods: ['POST'])]
    public function supprimEmployee(Employee $employee, Request $request, ProjectRepository $repo, Project $projet, EntityManagerInterface $em): Response
    {
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
        return $this->redirectToRoute('app_employee_affichemesprojets', ['id' => $user], Response::HTTP_SEE_OTHER);
    }
}
