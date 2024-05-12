<?php
// src/Security/AccessDeniedHandler.php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function handle(Request $request, ?\Throwable $exception = null) : ?Response
    {
        $url = $this->router->generate('app_error'); // Replace with your error route name
        $message = "Vous n'avez pas access a cette page";
        $statusCode = 403;

        return new Response($message, $statusCode, ['Location' => $url]);
    }
}
