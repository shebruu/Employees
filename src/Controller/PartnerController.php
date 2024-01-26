<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/partner')]
class PartnerController extends AbstractController
{
    #[Route('/', name: 'app_partner_index', methods: ['GET'])]
    public function index(PartnerRepository $partnerRepository): Response
    {

        $partners = $partnerRepository->findAll();
        return $this->render('partner/index.html.twig', [
            'partners' => $partners,

        ]);
    }

    public function somePageAction(PartnerRepository $partnerRepository): Response
    {
        $partners = $partnerRepository->findAll();

        return $this->render('partials/_footer.html.twig', [
            'partners' => $partners,
        ]);
    }
    #[Route('/{id}', name: 'app_partner_show', methods: ['GET'])]
    public function show(Partner $partner): Response
    {
        return $this->render('partner/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /*
    #[Route('/{id}/edit', name: 'app_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    */
    #[Route('/{id}', name: 'app_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $partner->getId(), $request->request->get('_token'))) {
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
    }
}
