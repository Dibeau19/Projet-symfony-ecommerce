<?php

namespace App\Controller;

use App\Entity\TShirt;
use App\Form\TShirt1Type;
use App\Repository\TShirtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/t/shirt')]
final class TShirtController extends AbstractController
{
    #[Route(name: 'app_t_shirt_index', methods: ['GET'])]
    public function index(TShirtRepository $tShirtRepository): Response
    {
        return $this->render('t_shirt/index.html.twig', [
            't_shirts' => $tShirtRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_t_shirt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $tShirt = new TShirt();
        $form = $this->createForm(TShirt1Type::class, $tShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tShirt);
            $entityManager->flush();

            return $this->redirectToRoute('app_t_shirt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('t_shirt/new.html.twig', [
            't_shirt' => $tShirt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_t_shirt_show', methods: ['GET'])]
    public function show(TShirt $tShirt): Response
    {
        return $this->render('t_shirt/show.html.twig', [
            't_shirt' => $tShirt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_t_shirt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TShirt $tShirt, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(TShirt1Type::class, $tShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_t_shirt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('t_shirt/edit.html.twig', [
            't_shirt' => $tShirt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_t_shirt_delete', methods: ['POST'])]
    public function delete(Request $request, TShirt $tShirt, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$tShirt->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tShirt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_t_shirt_index', [], Response::HTTP_SEE_OTHER);
    }
}
