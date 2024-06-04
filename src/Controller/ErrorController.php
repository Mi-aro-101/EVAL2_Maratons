<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(Throwable $exception): Response
    {
        $message = $exception->getMessage();
        // Do not mind this It does have statusCode indeed
        $status = $exception->getStatusCode();
        return $this->render('error/index.html.twig', [
            'controller_name' => 'ErrorController',
            'message' => $message,
            'status' => $status
        ]);
    }
}
