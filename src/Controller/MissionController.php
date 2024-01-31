<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;
use App\Entity\Employee;
use App\Entity\Status;

#[Route('{/mission')]
class MissionController extends AbstractController
{


    /**
     * Affiche toutes les missions.
     * 
     * @param MissionRepository $missionRepository
     * @return Response
     */
    #[Route('/', name: 'app_mission_index', methods: ['GET'])]
    public function index(MissionRepository $missionRepository): Response
    {
        /* récupération des mission de seulement de l utilisateur connecté
        $user = $this->getUser();

        if ($user) {
            $missions = $missionRepository->findByUser($user);
            */

        $employee = $this->getUser();
        dump($this->getUser());
        return $this->render('mission/index.html.twig', [
            'missions' => $missionRepository->findAll(),
        ]);
    }

    /**
     * Crée une nouvelle mission.
     * 
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/new', name: 'app_mission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    /**
     * Affiche les détails d'une mission spécifique.
     * 
     * @param int $id
     * @param Mission $mission
     * @return Response
     */
    #[Route('/{id}', name: 'app_mission_show', methods: ['GET'])]
    public function show(int $id, Mission $mission): Response
    {
        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
        ]);

        if (!$mission) {
            throw $this->createNotFoundException('La mission demandée n\'existe pas.');
        }
    }

    /**
     * Modifie une mission existante.
     * 
     * @param Request $request
     * @param Mission $mission
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/edit', name: 'app_mission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    /**
     * Supprime une mission.
     * 
     * @param Request $request
     * @param Mission $mission
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}', name: 'app_mission_delete', methods: ['POST'])]
    public function delete(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mission->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * Affiche les missions attribuées ou non attribuées à un employé.
     * 
     * @param Employee $employee
     * @param MissionRepository $repo
     * @return Response
     */
    #[Route('/mesmissions/{id}', name: 'app_mission_mesmissions', methods: ['GET'])]
    public function mes_missions(Employee $employee, MissionRepository $repo): Response
    {
        $missionsActives = $repo->findMissionsActifByEmployee($employee);

        $missionsNonAssignees = $repo->findMissionsNonAssigneesEtActives($employee);

        return $this->render('mission/mesmissions.html.twig', [
            'missionsActives' => $missionsActives,
            'missionsNonAssignees' => $missionsNonAssignees,
        ]);
    }


    /**
     * Met à jour le statut d'une mission pour un employé.
     * 
     * @param string $missionId
     * @param string $action
     * @param Employee $employee
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/mesmissions/{id}/update', name: 'app_mission_update', methods: ['POST'])]
    public function updateMission(Request $request,  Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $missionId = $request->request->get('missionId');
        $action = $request->request->get('action');
        $user = $this->getUser();
        $mission = $entityManager->getRepository(Mission::class)->find($missionId);
        $employee = $entityManager->getRepository(Employee::class)->find($user);



        switch ($action) {
            case 'accepter':
                // Logique pour accepter
                break;
            case 'rejoindre':
                $employee->addMission($mission);
                $mission->setStatus(Status::Encours);
                break;
            case 'terminer':
                $mission->setStatus(Status::Termine);
                break;
            default:
                throw new \Exception('Action non reconnue');
        }

        $entityManager->flush();

        return new Response('Action effectuée avec succès');
    }
}
