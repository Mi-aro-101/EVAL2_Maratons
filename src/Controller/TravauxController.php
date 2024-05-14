<?php

namespace App\Controller;

use App\Entity\Travaux;
use App\Form\TravauxType;
use App\Repository\TravauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/travaux')]
class TravauxController extends AbstractController
{
    #[Route('/', name: 'app_travaux_index', methods: ['GET'])]
    public function index(Request $request, TravauxRepository $travauxRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $travaux = $travauxRepository->paginateTravaux($page, $limit);
        $maxPage = ceil($travaux->getTotalItemCount() / $limit);
        return $this->render('travaux/index.html.twig', [
            'travauxes' => $travaux,
            'maxPage' => $maxPage,
            'page' => $page,
            'idPage' => 5
        ]);
    }

    #[Route('/new', name: 'app_travaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $travaux = new Travaux();
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($travaux);
            $entityManager->flush();

            return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('travaux/new.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
            'idPage' => 5
        ]);
    }

    #[Route('/{id}', name: 'app_travaux_show', methods: ['GET'])]
    public function show(Travaux $travaux): Response
    {
        return $this->render('travaux/show.html.twig', [
            'travaux' => $travaux,
        ]);
    }

    #[IsGranted("ROLE_ADMIN", message: "Cette page est inaccessiible")]
    #[Route('/{id}/edit', name: 'app_travaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Travaux $travaux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('travaux/edit.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
            'idPage' => 5
        ]);
    }

    #[Route('/{id}', name: 'app_travaux_delete', methods: ['POST'])]
    public function delete(Request $request, Travaux $travaux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travaux->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($travaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
    }
}
