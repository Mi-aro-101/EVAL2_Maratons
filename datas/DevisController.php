<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\ClientRepository;
use App\Repository\DevisRepository;
use App\Repository\TypeMaisonRepository;
use App\Service\DataManagerService;
use App\Service\DevisService;
use App\Service\TypeMaisonService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/devis')]
class DevisController extends AbstractController
{

    #[Route('/onload/csv', name: 'app_devis_load_csv', methods: ['GET', 'POST'])]
    public function readCsvAndPersist(Request $request, DataManagerService $dataManager, EntityManagerInterface $entityManager): Response
    {
        $file = $request->files->get('file');
            $thefile = fopen($file->getPathname(), 'r') or die("The file cannot be opened");
            if($file && $thefile){
                $exec = $dataManager->insertDevisMirror($thefile, $entityManager);
            }
            fclose($thefile);
        return $this->redirectToRoute('app_devis_import_csv');
    }

    #[Route('importer/csv', name: 'app_devis_import_csv', methods: ['get'])]
    public function importCsvTypeMaison(): Response
    {
        return $this->render('devis/import_csv.html.twig', [
            'idPage' => 8,
        ]);
    }

    #[IsGranted("ROLE_ADMIN", message: "Cette page est innaccessible")]
    #[Route('/admin/tab/board', name: 'app_devis_board_admin', methods: ['get'])]
    public function loadFormDashboard(): Response
    {
        return $this->render('charts/admin_dashboard.html.twig', [
            'idPage' => 1
        ]);
    }

    #[Route('/admin/display/board', name: 'app_display_board', methods: ['get'])]
    public function loadDashBoard(Request $request, DevisRepository $devisRepository, EntityManagerInterface $entityManager) : Response
    {
        $date = $request->query->get('annee');
        $stats = $devisRepository->getDevisTotalParMoisParAnnee($date, $entityManager);
        $result = json_encode($stats);
        $response = new Response($result);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[IsGranted("ROLE_ADMIN", message: "Cette page est innaccessible")]
    #[Route('/admin/tab/liste', name: 'app_devis_liste_admin', methods: ['get'])]
    public function getListeDevisAdmin(Request $request, DevisRepository $devisRepository) : Response
    {
        $page = $request->query->getInt('page', 1);
        $today = date('Y-m-d H:i:s');
        $limit = 5;
        $devis = $devisRepository->findDevisAlongPaiementPourcenage($page, $limit, $today);
        // dd($devis);
        $maxPage = ceil($devis->getTotalItemCount() / $limit);
        return $this->render('devis/devis_cours.html.twig', [
            'devis' => $devis,
            'maxPage' => $maxPage,
            'page' => $page,
            'idPage' => 4
        ]);
    }

    #[IsGranted("ROLE_ADMIN", message: "Cette page est innaccessible")]
    #[Route('/details/{id}', name: 'app_devis_details', methods: ['GET'])]
    public function detailsDevis(Devis $devis) : Response
    {
        return $this->render('devis/devis_details.html.twig', [
            'devis' => $devis,
            'idPage' => 4
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: "Cette page est innaccessible")]
    #[Route("/devis/en/cours", name: 'app_devis_en_cours', methods: ["GET"])]
    public function getDevisEncours(Request $request, DevisRepository $devisRepository)
    {
        $page = $request->query->getInt('page', 1);
        $today = date('Y-m-d H:i:s');
        $limit = 5;
        $devis = $devisRepository->findDevisEnCours($page, $limit, $today);
        $maxPage = ceil($devis->getTotalItemCount() / $limit);
        return $this->render('devis/devis_cours.html.twig', [
            'devis' => $devis,
            'maxPage' => $maxPage,
            'page' => $page,
            'idPage' => 4
        ]);
    }

    #[Route('/export/pdf/{id}', name: 'app_devis_show_pdf', methods: ['GET'])]
    public function export(Devis $devis)
    {
        $html = $this->renderView('devis/details_pdf.html.twig', [
            'title' => 'Devis en PDF',
            'devis' => $devis
        ]);
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return new Response($pdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="example.pdf"'
        ]);
    }

    #[Route('/', name: 'app_devis_index', methods: ['GET'])]
    public function index(SessionInterface $session, Request $request, DevisRepository $devisRepository): Response
    {
        $user = $session->get('PHPSESSID');
        $page = $request->query->getInt('page', 1);
        $limit = 5;
        $devis = $devisRepository->paginateDevis($page, $limit, $user);
        $maxPage = ceil($devis->getTotalItemCount() / $limit);
        return $this->render('devis/index.html.twig', [
            'devis' => $devis,
            'maxPage' => $maxPage,
            'page' => $page,
            'idPage' => 4
        ]);
    }

    #[Route('/new', name: 'app_devis_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session, TypeMaisonService $typeMaisonService, TypeMaisonRepository $typeMaisonRepository, Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository): Response
    {
        $devi = new Devis();
        $typeMaisons = $typeMaisonRepository->findAll();
        $type_maisons = $typeMaisonService->assignColor($typeMaisons);
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $session->get('PHPSESSID');
            $client = $clientRepository->find($client->getId());
            $devi->setClient($client);
            $devi->handleDatasThenPersist($request, $typeMaisonRepository, $entityManager);

            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/new.html.twig', [
            'devi' => $devi,
            'form' => $form,
            'type_maisons' => $type_maisons,
            'idPage' => 3
        ]);
    }

    #[Route('/{id}', name: 'app_devis_show', methods: ['GET'])]
    public function show(Devis $devi): Response
    {
        return $this->render('devis/show.html.twig', [
            'devi' => $devi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($devi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
