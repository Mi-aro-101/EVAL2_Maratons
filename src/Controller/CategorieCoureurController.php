<?php

namespace App\Controller;

use App\Entity\CategorieCoureur;
use App\Form\CategorieCoureurType;
use App\Repository\CategorieCoureurRepository;
use App\Service\CategorieCoureurService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/categorie/coureur')]
class CategorieCoureurController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\' avez pas acces a cette page', statusCode: 403)]
    #[Route('/generer', name:'app_generate_categorie')]
    public function generateCategorie(EntityManagerInterface $entityManager, CategorieCoureurRepository $categorieCoureurRepository,
        CategorieCoureurService $categorieCoureurService): Response
    {
        $categorieCoureurService->generate($entityManager, $categorieCoureurRepository);

        $this->addFlash('success', 'La generation de categorie a ete effectuee');
        return $this->redirectToRoute('app_generate_categorie_form', []);
    }

    #[IsGranted('ROLE_ADMIN', message: 'Vous n\' avez pas acces a cette page', statusCode: 403)]
    #[Route('/generer/form', name:'app_generate_categorie_form')]
    public function generateCategorieForm(EntityManagerInterface $entityManager, CategorieCoureurRepository $categorieCoureurRepository,
        CategorieCoureurService $categorieCoureurService): Response
    {

        return $this->render('admin/categorie_coureur/generate_index.html.twig', [
            'idPage' => 8
        ]);
    }

    #[Route('/', name: 'app_categorie_coureur_index', methods: ['GET'])]
    public function index(CategorieCoureurRepository $categorieCoureurRepository): Response
    {
        return $this->render('categorie_coureur/index.html.twig', [
            'categorie_coureurs' => $categorieCoureurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_coureur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieCoureur = new CategorieCoureur();
        $form = $this->createForm(CategorieCoureurType::class, $categorieCoureur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieCoureur);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_coureur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_coureur/new.html.twig', [
            'categorie_coureur' => $categorieCoureur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_coureur_show', methods: ['GET'])]
    public function show(CategorieCoureur $categorieCoureur): Response
    {
        return $this->render('categorie_coureur/show.html.twig', [
            'categorie_coureur' => $categorieCoureur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_coureur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieCoureur $categorieCoureur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieCoureurType::class, $categorieCoureur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_coureur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_coureur/edit.html.twig', [
            'categorie_coureur' => $categorieCoureur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_coureur_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieCoureur $categorieCoureur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieCoureur->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($categorieCoureur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_coureur_index', [], Response::HTTP_SEE_OTHER);
    }
}
