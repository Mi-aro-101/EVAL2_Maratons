<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OnloadController extends AbstractController
{
    #[Route('/', name: 'app_onload')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');
    }
}
