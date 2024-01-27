<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Entity\Link;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Dompdf\Dompdf; //Pour PDF
use Dompdf\Options; //Pour PDF
use Endroid\QrCode\QrCode; //Pour code QR

#[Route('/home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entityManager): Response   
    {
        $link = $entityManager->getRepository(Link::class)->findAll(); //Pour Liens
        //var_dump ($link);
        return $this->render('home/index.html.twig', ['link'=>$link]);
    }


    //Pour PDF
    #[Route('/download-pdf/{linkId}', name: 'download_pdf')]
    public function generatePdfAction(EntityManagerInterface $entityManager, $linkId): Response
    {
        $link = $entityManager->getRepository(Link::class)->find($linkId); 
    
        if (!$link) {
            throw $this->createNotFoundException('L\'ID spécifié n\'existe pas.');
        }
    
        $url = $link->getUrl();
        // Créer une instance
        $dompdf = new Dompdf();
    
        // Charger le contenu HTML a partir de l´url
        $html = file_get_contents($url);
    
        // Charger les options de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true); 
    
        // Appliquer les options
        $dompdf->setOptions($options);
    
        // Charger le contenu html dans Dompdf
        $dompdf->loadHtml($html);
    
        // Rendre le document html dans pdf
        $dompdf->render();
    
        // Générer la reponse pdf
        $pdfContent = $dompdf->output();
    
        // Envoyer la reponse pdf
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="document.pdf"');
    
        return $response;
    }
    
    //Localisation Google Maps
    #[Route('/headquarters_location', name: 'headquarters_location')]
    public function headquartersLocation(): Response
    {
        return $this->render('headquarters_location.html.twig', [
            'google_maps_api_key' => 'VOTRE_CLE_API_GOOGLE_MAPS',
        ]);
    }

    //Code QR
   // #[Route('/qr-code', name: 'qr_code')]
   // public function qrCode(): Response
   /// {
       // $qrCode = new QrCode('http://localhost:8888/home');
       //  $qrCode->setSize(300);
    
        // Obtenez le contenu du QR Code sous forme de chaîne
       //  $qrCodeContent = $qrCode->writeString();
    
        // Envoi du contenu en tant que réponse
       //  $response = new Response($qrCodeContent, Response::HTTP_OK, ['Content-Type' => $qrCode->getContentType()]);
    
        // return $response;
   //  }

   
}
