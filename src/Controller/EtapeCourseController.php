<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\EtapeCourse;
use App\Form\EtapeCourseType;
use App\Repository\EtapeCoureurRepository;
use App\Repository\EtapeCourseRepository;
use App\Service\EtapeCourseService;
use App\Service\ResultatService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/etape/course')]
class EtapeCourseController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('/import/csv', name: 'app_import_csv_etape', methods: ['GET'])]
    public function importCsv() : Response
    {
        return $this->render('admin/etape_course/import_csv.html.twig', [
            // 'idPage' => 3
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('import/valider', name: 'app_import_valider_etape', methods: ['POST'])]
    public function importValiderCsv(Request $request, EtapeCourseService $etapeService, EntityManagerInterface $entityManager, 
        ResultatService $resultatService, UserPasswordHasherInterface $hasher) : Response
    {
        // Manager etape.csv
        $etapes = $request->files->get('etape');
        $thefile = fopen($etapes->getPathname(), 'r') or die("The file cannot be opened");
        if($etapes && $thefile){
            $etapeService->etapeFromFile($thefile, $entityManager);
            $etapeService->insertDatasFromMirror($entityManager);
        }
        // Manage resultat.csv
        $resultats = $request->files->get('resultat');
        $resFile = fopen($resultats->getPathname(), 'r') or die("The file cannot be opened");
        if($resultats && $resFile){
            $resultatService->manageAll($resFile, $entityManager, $hasher);
        }
        $this->addFlash('success', 'Vos donnees ont ete importes vous pouvez les consulter');
        return $this->redirectToRoute('app_import_csv_etape', []);
    }

    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('/{id}/coureurs', name: 'app_etape_course_coureur', methods: ['GET', 'POST'])]
    public function coureursParEtape(EtapeCourse $etapeCourse, EtapeCoureurRepository $etapeCoureurRepository) : Response
    {
        $etapeCoureurs = $etapeCoureurRepository->findByEtapeCourse($etapeCourse);
        return $this->render('admin/etape_coureur/coureurs.html.twig', [
            'etape_coureurs' => $etapeCoureurs,
            'idPage' => 2,
            'etape_course' => $etapeCourse,
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('/{id}/affecter/temps', name: 'app_etape_course_by_course_admin', methods: ['GET', 'POST'])]
    public function etapeByCourseAdmin(Course $course, Request $request, EtapeCourseRepository $etapeCourseRepository) : Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $etapeCourses = $etapeCourseRepository->paginateEtapeCourseByCourse($page, $limit, $course);
        $maxPage = ceil($etapeCourses->getTotalItemCount() / $limit);
        return $this->render('admin/etape_course/index.html.twig', [
            'etape_courses' => $etapeCourses,
            'macPage' => $maxPage,
            'page' => $page,
            'idPage' => 2
        ]);
    }

    #[Route('/{id}', name: 'app_etape_course_by_course', methods: ['GET', 'POST'])]
    public function etapeByCourse(Course $course, Request $request, EtapeCourseRepository $etapeCourseRepository): Response
    {
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            return $this->redirectToRoute('app_etape_course_by_course_admin', ['id' => $course->getId()]);
        }
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $etapeCourses = $etapeCourseRepository->paginateEtapeCourseByCourse($page, $limit, $course);
        $maxPage = ceil($etapeCourses->getTotalItemCount() / $limit);
        return $this->render('etape_course/index.html.twig', [
            'etape_courses' => $etapeCourses,
            'maxPage' => $maxPage,
            'page' => $page,
            'idPage' => 2
        ]);
    }

    #[Route('/', name: 'app_etape_course_index', methods: ['GET'])]
    public function index(Request $request, EtapeCourseRepository $etapeCourseRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $etapeCourses = $etapeCourseRepository->paginateEtapeCourse($page, $limit);
        $maxPage = ceil($etapeCourses->getTotalItemCount() / $limit);
        return $this->render('etape_course/index.html.twig', [
            'etape_courses' => $etapeCourses,
            'macPage' => $maxPage,
            'page' => $page,
            'idPage' => 2
        ]);
    }

    #[Route('/new', name: 'app_etape_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etapeCourse = new EtapeCourse();
        $form = $this->createForm(EtapeCourseType::class, $etapeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etapeCourse);
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape_course/new.html.twig', [
            'etape_course' => $etapeCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etape_course_show', methods: ['GET'])]
    public function show(EtapeCourse $etapeCourse): Response
    {
        return $this->render('etape_course/show.html.twig', [
            'etape_course' => $etapeCourse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etape_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtapeCourse $etapeCourse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtapeCourseType::class, $etapeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape_course/edit.html.twig', [
            'etape_course' => $etapeCourse,
            'form' => $form,
            'idPage' => 2
        ]);
    }

    #[Route('/{id}', name: 'app_etape_course_delete', methods: ['POST'])]
    public function delete(Request $request, EtapeCourse $etapeCourse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etapeCourse->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($etapeCourse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etape_course_index', [], Response::HTTP_SEE_OTHER);
    }
}
