<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Form\InternType;
use App\Entity\Employee;

use App\Repository\InternRepository;
use App\Repository\DepartementRepository;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/intern')]
class InternController extends AbstractController
{
    /**
     * Affiche la liste des stagiaires.
     *
     * @param InternRepository $internRepository Repository pour accéder aux données des stagiaires.
     * @param EmployeeRepository $employeeRepo Repository pour accéder aux données des employés.
     * @param DepartementRepository $deptRepo Repository pour accéder aux données des départements.
     * @return Response Rendu de la vue avec les données des stagiaires.
     */
    #[Route('/', name: 'app_intern_index', methods: ['GET'])]
    public function index(InternRepository $internRepository, EmployeeRepository $employeeRepo, DepartementRepository $deptRepo): Response
    {
        $groupInterns = $deptRepo->finDepartmentsWithInterns();
        $freeEmployees = $employeeRepo->findEmployeesWithNoIntern();
        return $this->render('intern/index.html.twig', [
            'groupInterns' => $groupInterns,
            'freeEmployees' => $freeEmployees,
        ]);
    }

    #[Route('/new', name: 'app_intern_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $intern = new Intern();
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($intern);
            $entityManager->flush();

            return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intern/new.html.twig', [
            'intern' => $intern,
            'form' => $form,
        ]);
    }

    /**
     * Affiche les détails d'un stagiaire.
     *
     * @param Intern $intern L'entité stagiaire à afficher.
     * @return Response Une réponse HTTP.
     */
    #[Route('/{id}', name: 'app_intern_show', methods: ['GET'])]
    public function show(Intern $intern): Response
    {
        return $this->render('intern/show.html.twig', [
            'intern' => $intern,
        ]);
    }

    /**
     * Modifie un stagiaire existant.
     * Affiche un formulaire pour éditer un stagiaire et le traite une fois soumis.
     *
     * @param Request $request La requête HTTP.
     * @param Intern $intern L'entité stagiaire à éditer.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités pour la persistance.
     * @return Response Une réponse HTTP.
     */
    #[Route('/{id}/edit', name: 'app_intern_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intern $intern, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InternType::class, $intern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('intern/edit.html.twig', [
            'intern' => $intern,
            'form' => $form,
        ]);
    }

    /**
     * Supprime un stagiaire.
     *
     * @param Request $request La requête HTTP.
     * @param Intern $intern L'entité stagiaire à supprimer.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités pour la persistance.
     * @return Response Une réponse HTTP de redirection.
     */

    #[Route('/{id}', name: 'app_intern_delete', methods: ['POST'])]
    public function delete(Request $request, Intern $intern, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $intern->getId(), $request->request->get('_token'))) {
            $entityManager->remove($intern);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
    }




    /**
     * Action permettant à un utilisateur authentifié de superviser un stagiaire.
     *
     * @param Request $request La requête HTTP.
     * @param InternRepository $repo Le référentiel des stagiaires.
     * @param Intern $intern Le stagiaire à superviser.
     * @param EntityManagerInterface $em Le gestionnaire d'entités pour la persistance.
     * @return Response Une réponse HTTP de redirection vers la page d'affichage des stagiaires.
     */
    #[Route('/{id}/superviser', name: 'app_intern_supervise', methods: ['GET', 'POST'])]
    public function SupervIseintern(Intern $intern, EntityManagerInterface $em): Response
    {

        /*
        dump($intern);
        die();
        */
        // vérifie que l'utilisateur est entièrement authentifié.
        // $this->denyAccessUnlessGranted('IS_FULLY_AUTHENTICATED');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //récupère le superviseur  actuel, renvoie l employee connecté
        $user = $this->getUser();

        $intern->setSuperviseur($user);

        //execute les changements dans la base de données
        $em->flush();

        $this->addFlash('notice', $intern->getSuperviseur() ? 'Succès' : 'Erreur');
        // redirige l'utilisateur vers la page d'affichage des stagiaires. (employee/id/intern)
        return $this->redirectToRoute('app_employee_affichemesstagiaires', ['id' => $user], Response::HTTP_SEE_OTHER);
    }





    /**
     * Action permettant à un utilisateur authentifié ayant le rôle "ROLE_ADMIN" de gérer la supervision des stagiaires.
     *
     * @param Request $request La requête HTTP.
     * @param EmployeeRepository $employeeRepo Le référentiel des employés.
     * @param InternRepository $internRepo Le référentiel des stagiaires.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités pour la persistance.
     * @return Response Une réponse HTTP de redirection.
     */
    #[Route('/manage', name: 'app_intern_manage', methods: ['POST'])]
    public function manageIntern(Request $request, EmployeeRepository $employeeRepo, InternRepository $internRepo, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Vérifie quelle action a été déclenchée dans la requête POST.
        if ($request->request->get('btUnsupervise')) {
            //Récupérer le stagiaire et le superviseur
            $intern = $internRepo->find($request->request->get('btUnsupervise'));

            // Action : Retirer la supervision d'un stagiaire.
            $intern->setSuperviseur(null);

            $entityManager->flush();

            // Vérifie si l'action a réussi et ajoute un message flash approprié.
            if ($intern->getSuperviseur() == null) {
                $this->addFlash('notice', 'Succès!');
            } else {
                $this->addFlash('notice', 'Erreur : superviseur incorrectement attribué!');
            }
        } elseif ($request->request->get('btSupervise')) {
            //Récupérer le stagiaire et le superviseur
            // Action : Attribuer un superviseur à un stagiaire.
            $superviseur = $employeeRepo->find($request->request->get('superviseur'));
            $intern = $internRepo->find($request->request->get('btSupervise'));
            //Attribuer le superviseur au stagiaire
            $intern->setSuperviseur($superviseur);

            $entityManager->flush();

            // Vérifie si l'action a réussi et ajoute un message flash approprié.
            if ($intern->getSuperviseur() == $superviseur) {
                $this->addFlash('notice', 'Succès!');
            } else {
                $this->addFlash('notice', 'Erreur : superviseur incorrectement attribué!');
            }
        } else {
            $this->addFlash('notice', 'Erreur : aucune action sélectionnée!');
        }


        // Redirige l'utilisateur vers la page d'index des stagiaires.
        return $this->redirectToRoute('app_intern_index', [], Response::HTTP_SEE_OTHER);
    }
}
