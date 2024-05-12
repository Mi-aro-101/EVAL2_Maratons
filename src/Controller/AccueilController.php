<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Mr/Mme',
            'idPage' => 1
        ]);
    }

    #[Route('/accueil/admin', name: 'app_admin_accueil')]
    public function indexAdmin(): Response
    {
        return $this->render('accueil/index_admin.html.twig', [
            'controller_name' => 'Admin',
            'idPage' => 1
        ]);
    }
}