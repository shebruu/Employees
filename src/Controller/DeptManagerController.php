<?php

namespace App\Controller;

use App\Entity\DeptManager;
use App\Form\DeptManagerType;
use App\Repository\DeptManagerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dept_manager')]
class DeptManagerController extends AbstractController
{
    #[Route('/', name: 'app_dept_manager_index', methods: ['GET'])]
    public function index(DeptManagerRepository $deptManagerRepository): Response
    {
        return $this->render('dept_manager/index.html.twig', [
            'dept_managers' => $deptManagerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dept_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $deptManager = new DeptManager();
        $form = $this->createForm(DeptManagerType::class, $deptManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($deptManager);
            $entityManager->flush();

            return $this->redirectToRoute('app_dept_manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dept_manager/new.html.twig', [
            'dept_manager' => $deptManager,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dept_manager_show', methods: ['GET'])]
    public function show(DeptManager $deptManager): Response
    {
        return $this->render('dept_manager/show.html.twig', [
            'dept_manager' => $deptManager,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dept_manager_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DeptManager $deptManager, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeptManagerType::class, $deptManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dept_manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dept_manager/edit.html.twig', [
            'dept_manager' => $deptManager,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dept_manager_delete', methods: ['POST'])]
    public function delete(Request $request, DeptManager $deptManager, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deptManager->getId(), $request->request->get('_token'))) {
            $entityManager->remove($deptManager);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dept_manager_index', [], Response::HTTP_SEE_OTHER);
    }
}
