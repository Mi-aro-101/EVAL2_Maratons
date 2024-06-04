<?php

namespace App\Controller;

use App\Entity\Coureur;
use App\Entity\EtapeCoureur;
use App\Entity\EtapeCourse;
use App\Form\EtapeCoureurType;
use App\Repository\CoureurRepository;
use App\Repository\EtapeCoureurRepository;
use App\Repository\EtapeCourseRepository;
use App\Service\EtapeCoureurService;
use ContainerUu3z7gf\getEtapeCoureurService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/etape/coureur')]
class EtapeCoureurController extends AbstractController
{

    #[Route('classement/{id}', name: 'app_classement_etape')]
    public function getClassement(EtapeCourse $etapeCourse, EntityManagerInterface $entityManager, EtapeCoureurService $etapeCoureurService): Response
    {
        $head = "base.html.twig";
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            $head = 'admin/base.html.twig';
        }
        $classments = $etapeCoureurService->getClassementGeneral($entityManager, $etapeCourse->getId());
        dd($classments);
        return $this->render('admin/classement_etape_generale.html.twig', [
            'idPage' => 5,
            'classements' => $classments,
        ]);
    }

    #[Route('/{id}/equipe', name: 'app_etape_coureur_equipe', methods: ['GET'])]
    public function coureurEquipes(EtapeCourse $etapeCourse, EtapeCoureurRepository $etapeCoureurRepository): Response
    {
        $equipe = $this->getUser()->getEquipe();
        $etapeCoureurs = $etapeCoureurRepository->findCoureurByEquipeAndEtape($equipe, $etapeCourse);
        return $this->render('etape_coureur/index.html.twig', [
            'etape_coureurs' => $etapeCoureurs,
            'idPage' => 2,
            'etape_course' => $etapeCourse
        ]);
    }

    #[Route('/', name: 'app_etape_coureur_index', methods: ['GET'])]
    public function index(EtapeCoureurRepository $etapeCoureurRepository): Response
    {
        return $this->render('etape_coureur/index.html.twig', [
            'etape_coureurs' => $etapeCoureurRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_TEAM', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('/assigner/coureur', name:'assigner_coureur', methods: ['POST'])]
        public function assigner(Request $request, EtapeCourseRepository $etapeCourseRepository,
            EtapeCoureurService $etapeCoureurService, EntityManagerInterface $entityManager,
            CoureurRepository $coureurRepository, EtapeCoureurRepository $etapeCoureurRepository) : Response
        {
            $etapeCourse = $request->request->get('etape_course');
            $etapeCourse = $etapeCourseRepository->find($etapeCourse);
            $etapeCoureurService->control($request, $etapeCourse, $etapeCoureurRepository);
            $etapeCoureurService->flushAll($etapeCourse, $entityManager, $request, $coureurRepository);

            // return $this->redirectToRoute('app_etape_course_by_course', ['id' => $etapeCourse->getId()], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_etape_coureur_equipe', ['id' => $etapeCourse->getId()], Response::HTTP_SEE_OTHER);
        }

    #[Route('/new/{id}', name: 'app_etape_coureur_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_TEAM', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    public function new(EtapeCourse $etapeCourse, Request $request, EntityManagerInterface $entityManager,
        CoureurRepository $coureurRepository, EtapeCoureurService $etapeCoureurService): Response
    {
        $equipe = $this->getUser()->getEquipe();
        $coureurs = $coureurRepository->findByEquipe($equipe);
        $etapeCoureur = new EtapeCoureur();
        $etapeCoureur->setEtapeCourse($etapeCourse);
        $form = $this->createForm(EtapeCoureurType::class, $etapeCoureur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $etapeCoureurService->control($request, $etapeCoureur);
            // $etapeCoureurService->flushAll($etapeCoureur, $entityManager, $request, $coureurRepository);
            // $entityManager->persist($etapeCoureur);
            // $entityManager->flush();

            return $this->redirectToRoute('app_etape_coureur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape_coureur/new.html.twig', [
            'etape_coureur' => $etapeCoureur,
            'coureurs' => $coureurs,
            'form' => $form,
            'idPage' => 2
        ]);
    }

    #[Route('/{id}', name: 'app_etape_coureur_show', methods: ['GET'])]
    public function show(EtapeCoureur $etapeCoureur): Response
    {
        return $this->render('etape_coureur/show.html.twig', [
            'etape_coureur' => $etapeCoureur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etape_coureur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtapeCoureur $etapeCoureur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtapeCoureurType::class, $etapeCoureur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_course_coureur', ['id' => $etapeCoureur->getEtapeCourse()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape_coureur/edit.html.twig', [
            'etape_coureur' => $etapeCoureur,
            'form' => $form,
            'idPage' => 2
        ]);
    }

    #[Route('/{id}', name: 'app_etape_coureur_delete', methods: ['POST'])]
    public function delete(Request $request, EtapeCoureur $etapeCoureur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etapeCoureur->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($etapeCoureur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etape_coureur_index', [], Response::HTTP_SEE_OTHER);
    }
}
