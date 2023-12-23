<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends AbstractController
{
    #[Route('/demand', name: 'app_demand')]
    public function index(): Response
    {
        return $this->render('demand/index.html.twig', [
            'controller_name' => 'DemandController',
        ]);
    }
}
