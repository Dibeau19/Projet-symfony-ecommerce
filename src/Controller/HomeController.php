<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produit, PaginatorInterface $paginator, Request $request ): Response
    {
        $user = $this->getUser();
    
        $query = $produit->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC') 
            ->getQuery();

        
        $produits = $paginator->paginate(
            $query, 
            $request->query->getInt('page', 1), 
            10
        );

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'products' => $produits,
        ]);
    }

    #[Route('/remove/{id}', name: 'produit_remove')]
    public function delete(EntityManagerInterface $entityManager, Produit $produit){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager->remove($produit);
        $entityManager->flush();

        return new Response('Produit suppimé avec succès');
    }
}
