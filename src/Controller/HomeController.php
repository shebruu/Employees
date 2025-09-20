<?php
// src/Controller/HomeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/headquarters_location', name: 'headquarters_location')]
    public function headquartersLocation(): Response
    {
        return $this->render('headquarters_location.html.twig', [
            'google_maps_api_key' => 'VOTRE_CLE_API_GOOGLE_MAPS',
        ]);
    }
}
