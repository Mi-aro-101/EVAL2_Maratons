<?php

namespace App\Controller;

use App\Entity\PointRang;
use App\Form\PointRangType;
use App\Repository\EtapeCourseRepository;
use App\Repository\PointRangRepository;
use App\Service\PointRangService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/point/rang')]
class PointRangController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('/import/csv', name: 'app_import_csv_points', methods: ['GET'])]
    public function importCsv() : Response
    {
        return $this->render('admin/point_rang/import_csv.html.twig', [
            'idPage' => 4
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas access a cette page", statusCode: 403)]
    #[Route('import/valider', name: 'app_import_valider_points', methods: ['POST'])]
    public function importValiderCsv(Request $request, PointRangService $pointRangService, EntityManagerInterface $entityManager,
        EtapeCourseRepository $etapeCourseRepository) : Response
    {
        $pointRangs = $request->files->get('points');
        $thefile = fopen($pointRangs->getPathname(), 'r') or die("The file cannot be opened");
        if($pointRangs && $thefile){
            $exec = $pointRangService->pointFromFile($thefile, $entityManager);
            $exec2 = $pointRangService->insertDataFromMirrors($entityManager, $etapeCourseRepository);
        }
        $this->addFlash('success', 'Vos donnees ont ete importes vous pouvez les consulter');
        return $this->redirectToRoute('app_import_csv_points', []);
    }

    #[Route('/', name: 'app_point_rang_index', methods: ['GET'])]
    public function index(PointRangRepository $pointRangRepository): Response
    {
        return $this->render('point_rang/index.html.twig', [
            'point_rangs' => $pointRangRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_point_rang_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pointRang = new PointRang();
        $form = $this->createForm(PointRangType::class, $pointRang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pointRang);
            $entityManager->flush();

            return $this->redirectToRoute('app_point_rang_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('point_rang/new.html.twig', [
            'point_rang' => $pointRang,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_point_rang_show', methods: ['GET'])]
    public function show(PointRang $pointRang): Response
    {
        return $this->render('point_rang/show.html.twig', [
            'point_rang' => $pointRang,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_point_rang_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PointRang $pointRang, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PointRangType::class, $pointRang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_point_rang_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('point_rang/edit.html.twig', [
            'point_rang' => $pointRang,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_point_rang_delete', methods: ['POST'])]
    public function delete(Request $request, PointRang $pointRang, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pointRang->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($pointRang);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_point_rang_index', [], Response::HTTP_SEE_OTHER);
    }
}
