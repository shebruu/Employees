<?php

namespace App\Controller;

use App\Entity\DeptEmp;
use App\Form\DeptEmpType;
use App\Repository\DeptEmpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dept_emp')]
class DeptEmpController extends AbstractController
{
    #[Route('/', name: 'app_dept_emp_index', methods: ['GET'])]
    public function index(DeptEmpRepository $deptEmpRepository): Response
    {
        return $this->render('dept_emp/index.html.twig', [
            'dept_emps' => $deptEmpRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dept_emp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $deptEmp = new DeptEmp();
        $form = $this->createForm(DeptEmpType::class, $deptEmp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($deptEmp);
            $entityManager->flush();

            return $this->redirectToRoute('app_dept_emp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dept_emp/new.html.twig', [
            'dept_emp' => $deptEmp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dept_emp_show', methods: ['GET'])]
    public function show(DeptEmp $deptEmp): Response
    {
        return $this->render('dept_emp/show.html.twig', [
            'dept_emp' => $deptEmp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dept_emp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DeptEmp $deptEmp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeptEmpType::class, $deptEmp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dept_emp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dept_emp/edit.html.twig', [
            'dept_emp' => $deptEmp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dept_emp_delete', methods: ['POST'])]
    public function delete(Request $request, DeptEmp $deptEmp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deptEmp->getId(), $request->request->get('_token'))) {
            $entityManager->remove($deptEmp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dept_emp_index', [], Response::HTTP_SEE_OTHER);
    }
}
