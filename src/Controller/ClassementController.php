<?php

namespace App\Controller;

use App\Entity\Classement;
use App\Entity\EtapeCourse;
use App\Form\ClassementType;
use App\Repository\CategorieCoureurRepository;
use App\Repository\ClassementRepository;
use App\Repository\CourseRepository;
use App\Repository\EtapeCourseRepository;
use App\Service\ClassementCategorieService;
use App\Service\ClassementService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classement')]
class ClassementController extends AbstractController
{

    #[Route('voir/certificat/vainqueur', name:'app_voir_certificat_vainqueur', methods: ['GET'])]
    public function voirCertificat(Request $request, ClassementCategorieService $classementCategorieService, 
        ClassementService $classementService, EntityManagerInterface $entityManager, CategorieCoureurRepository $categorieCoureurRepository) : Response
    {
        $categorie = $request->query->get('categorie');
        if($categorie == 'general'){
            $categorie = "générale";
            $vainqueurs = $classementService->getVainqueurClassementGeneral($entityManager);
        }
        else{
            $categorie = $categorieCoureurRepository->findByNomCategorie($categorie)[0];
            $categorieid = $categorie->getId();
            $vainqueurs = $classementCategorieService->getVainqueurByCategorie($categorieid, $entityManager);
            $categorie = $categorie->getNomCategorie();
        }
        $html = $this->renderView('classement/certificat.html.twig', [
            'title' => 'Devis en PDF',
            'vainqueurs' => $vainqueurs,
            'categorie' => $categorie,
        ]);

        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);

        $pdf = new Dompdf($pdfOptions);
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return new Response($pdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certificat.pdf"'
        ]);
        // return $this->render('classement/certificat.html.twig', [
        //     'vainqueurs' => $vainqueurs,
        //     'categorie' => $categorie,
        // ]);
    }

    #[Route('voir/equipe', name: 'app_voir_classement_par_equipe')]
    public function voirClassementParEquipe(EntityManagerInterface $entityManager, ClassementService $classementService,
        CategorieCoureurRepository $categorieCoureurRepository): Response
    {
        $head = 'base.html.twig';
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            $head = "admin/base.html.twig";
        $classements = $classementService->getClassementGeneral($entityManager);
        // dd($classements);
        return $this->render('classement/equipe.html.twig', [
            'idPage' => 6,
            'head' => $head,
            'classements' => $classements,
            'categorie' => 'general',
            'categorie_coureurs' => $categorieCoureurRepository->findAll()
        ]);
    }

    #[Route('voir/par/etape/{id}', name: 'app_voir_classement_par_etape', methods: ['GET', 'POST'])]
public function voirClassementParEtape(EtapeCourse $etapeCourse, ClassementRepository $classementRepository, 
        CategorieCoureurRepository $categorieCoureurRepository) : Response
    {
        $head = 'base.html.twig';
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            $head = "admin/base.html.twig";

        $classements = $classementRepository->findByEtapeCourse($etapeCourse, [
            'rang' => 'ASC'
        ]);

        $categorie = $categorieCoureurRepository->findAll();
        return $this->render('classement/index.html.twig', [
            'idPage' => 6,
            'classements' => $classements,
            'head' => $head,
            'categorie_coureurs' => $categorie,
            'etape_id' => $etapeCourse->getId(),
            'categorie' => 'general'
        ]);
    }

    #[Route('/par/etape', name: 'app_classement_par_etape')]
    public function loadEtape(EtapeCourseRepository $etapeCourseRepository, CourseRepository $courseRepository) : Response
    {
        $head = 'base.html.twig';
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            $head = "admin/base.html.twig";
        $course = $courseRepository->findByNomCourse('Course')[0];
        $etapesCourse = $etapeCourseRepository->findByCourse($course);
        return $this->render('classement/etape_course.html.twig', [
            'idPage' => 6,
            'etape_courses' => $etapesCourse,
            'head' => $head,
        ]);
    }

    #[Route('/generer', name: 'app_generate_classement')]
    public function generate(EntityManagerInterface $entityManager, ClassementService $classementService, ClassementCategorieService $classementCategorieService) : Response
    {
        $classementService->genererClassement($entityManager);
        $classementCategorieService->genererClassementCategorie($entityManager);
        $this->addFlash('success', 'Les classements ont ete regenere');
        return $this->redirectToRoute('app_page_generate_classement', []);
    }

    #[Route('/page/generer', name: 'app_page_generate_classement')]
    public function loadPageGenerateClassement() : Response
    {
        return $this->render('admin/classement/generate_index.html.twig', [
            'idPage' => 6
        ]);
    }

    #[Route('/', name: 'app_classement_index', methods: ['GET'])]
    public function index(ClassementRepository $classementRepository): Response
    {
        $head = "base.html.twig";
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            $head = "admin/base.html.twig";
        return $this->render('classement/index.html.twig', [
            'classements' => $classementRepository->findAll(),
            'idPage' => 6,
            'head' => $head
        ]);
    }

    #[Route('/new', name: 'app_classement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classement = new Classement();
        $form = $this->createForm(ClassementType::class, $classement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classement);
            $entityManager->flush();

            return $this->redirectToRoute('app_classement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classement/new.html.twig', [
            'classement' => $classement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classement_show', methods: ['GET'])]
    public function show(Classement $classement): Response
    {
        return $this->render('classement/show.html.twig', [
            'classement' => $classement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Classement $classement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClassementType::class, $classement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classement/edit.html.twig', [
            'classement' => $classement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classement_delete', methods: ['POST'])]
    public function delete(Request $request, Classement $classement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classement->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($classement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classement_index', [], Response::HTTP_SEE_OTHER);
    }
}
