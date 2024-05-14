<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Service\ClientService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client/login', name: 'app_client_login')]
    public function index(): Response
    {
        return $this->render('client/login.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/client/login/validate', name: 'app_login_client_validate')]
    public function login(SessionInterface $session, Request $request, EntityManagerInterface $entityManager, ClientService $clientService, ClientRepository $clientRepository) : Response
    {
        $telephone = $request->request->get('telephone');
        $telephone = $clientService->formatTelephone($telephone);
        $exists = $clientService->userExist($telephone, $clientRepository);
        $clientService->checkFormat($telephone);
        if(!$exists){
            $clientService->newUser($telephone, $entityManager);
        }
        $user = $clientRepository->findBy(['telephone' => $telephone]);
        $session->set('PHPSESSID', $user[0]);

        return $this->redirectToRoute('app_accueil');
    }
}
