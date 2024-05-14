<?php

namespace App\Controller;

use App\Entity\TypeMaison;
use App\Form\TypeMaisonType;
use App\Repository\TypeMaisonRepository;
use App\Service\TypeMaisonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/maison')]
class TypeMaisonController extends AbstractController
{
    #[Route('/prendre/devis/{id}', name: 'app_type_maison_devis', methods: ['get'])]
    public function storeMaisonAndChooseFinition(SessionInterface $session, TypeMaison $typeMaison) : Response
    {
        dd($typeMaison->getTravauxMaisons()[0]->getTravaux()->getPrixUnitaire());
        if($session->has('maison')){
            $session->remove('maison');
        }
        $session->set('maison', $typeMaison);
        return $this->redirectToRoute('app_type_finition_index');
    }

    #[Route('/', name: 'app_type_maison_index', methods: ['GET'])]
    public function index(TypeMaisonRepository $typeMaisonRepository, TypeMaisonService $typeMaisonService): Response
    {
        $typeMaisons = $typeMaisonRepository->findAll();
        $type_maisons = $typeMaisonService->assignColor($typeMaisons);
        return $this->render('type_maison/index.html.twig', [
            'type_maisons' => $type_maisons,
            'idPage' => 2
        ]);
    }

    #[Route('/new', name: 'app_type_maison_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeMaison = new TypeMaison();
        $form = $this->createForm(TypeMaisonType::class, $typeMaison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeMaison);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_maison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_maison/new.html.twig', [
            'type_maison' => $typeMaison,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_maison_show', methods: ['GET'])]
    public function show(TypeMaison $typeMaison): Response
    {
        return $this->render('type_maison/show.html.twig', [
            'type_maison' => $typeMaison,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_maison_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeMaison $typeMaison, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeMaisonType::class, $typeMaison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_maison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_maison/edit.html.twig', [
            'type_maison' => $typeMaison,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_maison_delete', methods: ['POST'])]
    public function delete(Request $request, TypeMaison $typeMaison, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeMaison->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typeMaison);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_maison_index', [], Response::HTTP_SEE_OTHER);
    }
}
