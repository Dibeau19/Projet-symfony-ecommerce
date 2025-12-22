<?php

namespace App\Controller;

use App\Entity\CarteCredit;
use App\Form\CarteCreditType;
use App\Repository\CarteCreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/carte/credit')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CarteCreditController extends AbstractController
{
    #[Route('/new', name: 'app_carte_credit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carteCredit = new CarteCredit();
        $form = $this->createForm(CarteCreditType::class, $carteCredit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carteCredit->setUser($this->getUser());
            $entityManager->persist($carteCredit);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('carte_credit/new.html.twig', [
            'carte_credit' => $carteCredit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carte_credit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarteCredit $carteCredit, EntityManagerInterface $entityManager): Response
    {
        if ($carteCredit->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(CarteCreditType::class, $carteCredit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('carte_credit/edit.html.twig', [
            'carte_credit' => $carteCredit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carte_credit_delete', methods: ['POST'])]
    public function delete(Request $request, CarteCredit $carteCredit, EntityManagerInterface $entityManager): Response
    {
        if ($carteCredit->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$carteCredit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($carteCredit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_profile', [], Response::HTTP_SEE_OTHER);
    }
}
