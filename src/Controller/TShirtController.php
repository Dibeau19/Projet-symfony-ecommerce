<?php

namespace App\Controller;

use App\Entity\Image; 
use App\Entity\TShirt;
use App\Form\TShirt1Type;
use App\Repository\TShirtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile; 
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

    #[Route('/admin', name: 'app_t_shirt_admin', methods: ['GET'])]
    public function admin(TShirtRepository $tShirtRepository): Response
    {
        return $this->render('t_shirt/adminIndex.html.twig', [
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
            
            $imageFiles = $form->get('images')->getData();

            if ($imageFiles && !is_array($imageFiles)) {
                $imageFiles = [$imageFiles];
            }

            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    if (!$imageFile instanceof UploadedFile) {
                        continue;
                    }

                    $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );

                    $image = new Image();
                    $image->setUrl($newFilename);
                    
                    $tShirt->addImage($image);
                    
                    $entityManager->persist($image);
                }
            }

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
        return $this->render('produit/show.html.twig', [
            'produit' => $tShirt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_t_shirt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TShirt $tShirt, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $form = $this->createForm(TShirt1Type::class, $tShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFiles = $form->get('images')->getData();

            if ($imageFiles && !is_array($imageFiles)) {
                $imageFiles = [$imageFiles];
            }

            if ($imageFiles) {
                foreach ($imageFiles as $imageFile) {
                    if (!$imageFile instanceof UploadedFile) {
                        continue;
                    }

                    $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );

                    $image = new Image();
                    $image->setUrl($newFilename);
                    
                    $tShirt->addImage($image);
                    $entityManager->persist($image);
                }
            }

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