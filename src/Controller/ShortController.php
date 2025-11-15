<?php

namespace App\Controller;

use App\Entity\Short;
use App\Form\Short1Type;
use App\Repository\ShortRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/short')]
final class ShortController extends AbstractController
{
    #[Route(name: 'app_short_index', methods: ['GET'])]
    public function index(ShortRepository $shortRepository): Response
    {
        return $this->render('short/index.html.twig', [
            'shorts' => $shortRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_short_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $short = new Short();
        $form = $this->createForm(Short1Type::class, $short);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($short);
            $entityManager->flush();

            return $this->redirectToRoute('app_short_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('short/new.html.twig', [
            'short' => $short,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_short_show', methods: ['GET'])]
    public function show(Short $short): Response
    {
        return $this->render('short/show.html.twig', [
            'short' => $short,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_short_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Short $short, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(Short1Type::class, $short);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_short_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('short/edit.html.twig', [
            'short' => $short,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_short_delete', methods: ['POST'])]
    public function delete(Request $request, Short $short, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$short->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($short);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_short_index', [], Response::HTTP_SEE_OTHER);
    }
}
