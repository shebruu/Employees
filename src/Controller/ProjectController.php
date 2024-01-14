<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Ptoject;
use App\Repository\ProjectRepository;

#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project')]
    public function index(ProjectRepository $projectrepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectrepository->findProjetsWithDetails(),
        ]);
    }
}
