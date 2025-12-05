<?php

namespace App\Controller;

use App\Entity\Image; 
use App\Entity\Pantalon;
use App\Form\Pantalon1Type;
use App\Repository\PantalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


#[Route('/pantalon')]
final class PantalonController extends AbstractController
{
    #[Route(name: 'app_pantalon_index', methods: ['GET'])]
    public function index(PantalonRepository $pantalonRepository): Response
    {
        return $this->render('pantalon/index.html.twig', [
            'pantalons' => $pantalonRepository->findAll(),
        ]);
    }

    #[Route('/admin', name: 'app_pantalon_admin', methods: ['GET'])]
    public function admin(PantalonRepository $pantalonRepository): Response
    {
        return $this->render('pantalon/adminIndex.html.twig', [
            'pantalons' => $pantalonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pantalon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $pantalon = new Pantalon();
    $form = $this->createForm(Pantalon1Type::class, $pantalon);
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
                
                $pantalon->addImage($image);
                $entityManager->persist($image);
            }
        }

        $entityManager->persist($pantalon);
        $entityManager->flush();

        return $this->redirectToRoute('app_pantalon_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('pantalon/new.html.twig', [
        'pantalon' => $pantalon,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_pantalon_show', methods: ['GET'])]
    public function show(Pantalon $pantalon): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $pantalon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pantalon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pantalon $pantalon, EntityManagerInterface $entityManager): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
    $form = $this->createForm(Pantalon1Type::class, $pantalon);
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

                $pantalon->addImage($image);
                $entityManager->persist($image);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_pantalon_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('pantalon/edit.html.twig', [
        'pantalon' => $pantalon,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_pantalon_delete', methods: ['POST'])]
    public function delete(Request $request, Pantalon $pantalon, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$pantalon->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pantalon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pantalon_index', [], Response::HTTP_SEE_OTHER);
    }
}