<?php

namespace App\Controller;

use App\Entity\Penalite;
use App\Form\PenaliteType;
use App\Repository\PenaliteRepository;
use App\Service\PenaliteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/penalite')]
class PenaliteController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message: 'Voud n\'avez pas access a cette page', statusCode: 403)]
    #[Route('/', name: 'app_penalite_index', methods: ['GET'])]
    public function index(PenaliteRepository $penaliteRepository): Response
    {
        return $this->render('penalite/index.html.twig', [
            'penalites' => $penaliteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_penalite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PenaliteService $penaliteService): Response
    {
        $penalite = new Penalite();
        $form = $this->createForm(PenaliteType::class, $penalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $penaliteService->insertPenalite($penalite, $request, $entityManager);
            // $entityManager->persist($penalite);
            // $entityManager->flush();

            $this->addFlash('warning', 'Affectation de penalite effectue, vous pouvez regenerer le classement pour sceller les penalites');
            return $this->redirectToRoute('app_penalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('penalite/new.html.twig', [
            'penalite' => $penalite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_penalite_show', methods: ['GET'])]
    public function show(Penalite $penalite): Response
    {
        return $this->render('penalite/show.html.twig', [
            'penalite' => $penalite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_penalite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Penalite $penalite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PenaliteType::class, $penalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_penalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('penalite/edit.html.twig', [
            'penalite' => $penalite,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: 'Voud n\'avez pas access a cette page', statusCode: 403)]
    #[Route('/{id}', name: 'app_penalite_delete', methods: ['POST'])]
    public function delete(Request $request, Penalite $penalite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$penalite->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($penalite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_penalite_index', [], Response::HTTP_SEE_OTHER);
    }
}
