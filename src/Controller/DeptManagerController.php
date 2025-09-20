<?php

namespace App\Controller;

use App\Controller\Twig\Environment;

use App\Repository\EmployeeRepository;
use App\Repository\DepartementRepository;

use App\Entity\DeptManager;
use App\Entity\Employee;

use App\Form\DeptManagerType;
use App\Repository\DeptManagerRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/dept-manager')]
class DeptManagerController extends AbstractController
{
    #[Route('/', name: 'app_dept_manager_index', methods: ['GET'])]
    public function index(DeptManagerRepository $repo): Response
    {

        /*
        ou via methodes predefini
        $managersName= array_map(function($dm){
            return $dm -> getEmployee()->getFirstName()
        })
         */
        $deptManagers = $repo->findAll();
        //$managerNamesandDep = $repo->findManagerNamesWithDepartments();
        //dd($managerNamesandDep);
        return $this->render('dept_manager/index.html.twig', [
            'dept_managers' => $deptManagers,
            //'names' => $managerNamesandDep

        ]);
    }

    #[Route('/new', name: 'app_dept_manager_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        // Sécurité : accessible uniquement aux admins
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $deptManager = new DeptManager();
        $form = $this->createForm(DeptManagerType::class, $deptManager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification d'unicité du manager par département et période
            $departement = $deptManager->getDepartement();
            $fromDate = $deptManager->getFromDate();
            $toDate = $deptManager->getToDate();

            $repo = $entityManager->getRepository(DeptManager::class);
            $qb = $repo->createQueryBuilder('dm');
            $qb->where('dm.departement = :departement')
                ->andWhere('(:fromDate <= dm.toDate OR dm.toDate IS NULL)')
                ->andWhere('(:toDate >= dm.fromDate OR :toDate IS NULL)')
                ->setParameter('departement', $departement)
                ->setParameter('fromDate', $fromDate)
                ->setParameter('toDate', $toDate);

            $existing = $qb->getQuery()->getResult();

            if (count($existing) > 0) {
                $this->addFlash('danger', 'Il existe déjà un manager pour ce département sur la période sélectionnée.');
            } else {
                $entityManager->persist($deptManager);
                $entityManager->flush();

                return $this->redirectToRoute('app_dept_manager_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('dept_manager/new.html.twig', [
            'dept_manager' => $deptManager,
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: 'app_dept_manager_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérez les valeurs des clés composites depuis la requête
        $deptName = $request->request->get('deptName');
        $employeeId = $request->request->get('employeeId');

        // Recherchez l'enregistrement à supprimer en fonction des clés composites
        $deptManager = $entityManager->getRepository(DeptManager::class)->findOneBy([
            'deptName' => $deptName,
            'employeeId' => $employeeId,
        ]);

        // Vérifiez si l'enregistrement a été trouvé
        if ($deptManager !== null) {
            $entityManager->remove($deptManager);
            $entityManager->flush();
        }

        // Render the specific template after the delete action
        return $this->render('dept_manager/_delete_form.html.twig', [
            // Pass any necessary data to the template
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

    /*
    #[Route('/{id}', name: 'app_dept_manager_delete', methods: ['POST'])]
    public function delete(Request $request, DeptManager $deptManager, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deptManager->getId(), $request->request->get('_token'))) {
            $entityManager->remove($deptManager);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dept_manager_index', [], Response::HTTP_SEE_OTHER);
    }
    */
}
