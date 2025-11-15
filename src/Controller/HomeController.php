<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produit): Response
    {

        
        $user = $this->getUser();
        $produits = $produit->findAll();

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
