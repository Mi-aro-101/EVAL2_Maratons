<?php

namespace App\Controller;

use App\Entity\ClassementCategorie;
use App\Form\ClassementCategorieType;
use App\Repository\CategorieCoureurRepository;
use App\Repository\ClassementCategorieRepository;
use App\Repository\EtapeCourseRepository;
use App\Service\ClassementCategorieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classement/categorie')]
class ClassementCategorieController extends AbstractController
{

    #[Route('/trier/equipe', name: 'app_trier_classement_equipe_categorie', methods: ['POST'])]
    public function trierEquipeCategorie(Request $request, CategorieCoureurRepository $categorieCoureurRepository, 
        ClassementCategorieService $classementCategorieService, EntityManagerInterface $entityManager) : Response
    {
        $head = 'base.html.twig';
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            $head = "admin/base.html.twig";
        $categorieid = $request->request->get('categorie');
        $categorie = $categorieCoureurRepository->find($categorieid);
        $classements = $classementCategorieService->getClassementEquipeByCategorie($entityManager, $categorieid);
        return $this->render('classement/equipe.html.twig', [
            'idPage' => 6,
            'head' => $head,
            'classements' => $classements,
            'categorie' => $categorie->getNomCategorie(),
            'categorie_coureurs' => $categorieCoureurRepository->findAll()
        ]);
    }

    #[Route('/trier', name: 'app_trier_classement_categorie', methods: ['POST'])]
    public function trierParCategorie(Request $request, ClassementCategorieRepository $classementCategorieRepository,
        EtapeCourseRepository $etapeCourseRepository, CategorieCoureurRepository $categorieCoureurRepository): Response
    {
        $head = 'base.html.twig';
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            $head = "admin/base.html.twig";

        $categorieid = $request->request->get('categorie');
        $etapeid = $request->request->get('etape');
        $categorie = $categorieCoureurRepository->find($categorieid);
        $classements = $classementCategorieRepository->findBy([
            'categorieCoureur' => $categorieid,
            'etapeCourse' => $etapeid
        ], [
            'rang' => 'ASC'
        ]);

        return $this->render('classement/index.html.twig', [
            'idPage' => 6,
            'classements' => $classements,
            'head' => $head,
            'categorie_coureurs' => $categorieCoureurRepository->findAll(),
            'etape_id' => $etapeid,
            'categorie' => $categorie->getNomCategorie(),
        ]);
    }

    #[Route('/', name: 'app_classement_categorie_index', methods: ['GET'])]
    public function index(ClassementCategorieRepository $classementCategorieRepository): Response
    {
        return $this->render('classement_categorie/index.html.twig', [
            'classement_categories' => $classementCategorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classement_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classementCategorie = new ClassementCategorie();
        $form = $this->createForm(ClassementCategorieType::class, $classementCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classementCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_classement_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classement_categorie/new.html.twig', [
            'classement_categorie' => $classementCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classement_categorie_show', methods: ['GET'])]
    public function show(ClassementCategorie $classementCategorie): Response
    {
        return $this->render('classement_categorie/show.html.twig', [
            'classement_categorie' => $classementCategorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classement_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClassementCategorie $classementCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClassementCategorieType::class, $classementCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classement_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classement_categorie/edit.html.twig', [
            'classement_categorie' => $classementCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classement_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, ClassementCategorie $classementCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classementCategorie->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($classementCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classement_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
