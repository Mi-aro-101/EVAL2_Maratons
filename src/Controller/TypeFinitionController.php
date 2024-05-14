<?php

namespace App\Controller;

use App\Entity\TypeFinition;
use App\Form\TypeFinitionType;
use App\Repository\TypeFinitionRepository;
use App\Service\TypeFinitionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/finition')]
class TypeFinitionController extends AbstractController
{
    #[Route('/', name: 'app_type_finition_index', methods: ['GET'])]
    public function index(TypeFinitionRepository $typeFinitionRepository, TypeFinitionService $typeFinitionService): Response
    {
        $typeFinitions = $typeFinitionRepository->findAll();
        $type_finitions = $typeFinitionService->assignColor($typeFinitions);
        return $this->render('type_finition/index.html.twig', [
            'type_finitions' => $type_finitions,
            'idPage' => 2
        ]);
    }

    #[Route('/new', name: 'app_type_finition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeFinition = new TypeFinition();
        $form = $this->createForm(TypeFinitionType::class, $typeFinition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeFinition);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_finition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_finition/new.html.twig', [
            'type_finition' => $typeFinition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_finition_show', methods: ['GET'])]
    public function show(TypeFinition $typeFinition): Response
    {
        return $this->render('type_finition/show.html.twig', [
            'type_finition' => $typeFinition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_finition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeFinition $typeFinition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeFinitionType::class, $typeFinition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_finition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_finition/edit.html.twig', [
            'type_finition' => $typeFinition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_finition_delete', methods: ['POST'])]
    public function delete(Request $request, TypeFinition $typeFinition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFinition->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typeFinition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_finition_index', [], Response::HTTP_SEE_OTHER);
    }
}
