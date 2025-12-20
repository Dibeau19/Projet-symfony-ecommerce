<?php

namespace App\Controller;

use App\Entity\Image; 
use App\Entity\Pull;
use App\Form\Pull1Type;
use App\Repository\PullRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/pull')]
final class PullController extends AbstractController
{
    #[Route(name: 'app_pull_index', methods: ['GET'])]
    public function index(PullRepository $pullRepository, PaginatorInterface $paginator, Request $request ): Response
    {
        $query = $pullRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC') 
            ->getQuery();

        
        $pulls = $paginator->paginate(
            $query, 
            $request->query->getInt('page', 1), 
            10
        );
        return $this->render('pull/index.html.twig', [
            'pulls' => $pulls,
        ]);
    }

    #[Route('/admin', name: 'app_pull_admin', methods: ['GET'])]
    public function admin(PullRepository $pullRepository, PaginatorInterface $paginator, Request $request ): Response
    {

        $query = $pullRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC') 
            ->getQuery();

        
        $pulls = $paginator->paginate(
            $query, 
            $request->query->getInt('page', 1), 
            10
        );

        return $this->render('pull/adminIndex.html.twig', [
            'pulls' => $pulls,
        ]);
    }

    #[Route('/new', name: 'app_pull_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $pull = new Pull();
        $form = $this->createForm(Pull1Type::class, $pull);
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
                    
                    $pull->addImage($image);
                    $entityManager->persist($image);
                }
            }

            $entityManager->persist($pull);
            $entityManager->flush();

            return $this->redirectToRoute('app_pull_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pull/new.html.twig', [
            'pull' => $pull,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pull_show', methods: ['GET'])]
    public function show(Pull $pull): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $pull,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pull_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pull $pull, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $form = $this->createForm(Pull1Type::class, $pull);
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
                    
                    $pull->addImage($image);
                    $entityManager->persist($image);
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_pull_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pull/edit.html.twig', [
            'pull' => $pull,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pull_delete', methods: ['POST'])]
    public function delete(Request $request, Pull $pull, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$pull->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pull);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pull_index', [], Response::HTTP_SEE_OTHER);
    }
}