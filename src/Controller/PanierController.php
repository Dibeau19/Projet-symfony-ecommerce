<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;

#[Route('/panier', name: 'panier_')]
final class PanierController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get('panier', []);

        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantiter) {
            $produit = $produitRepository->find($id);

            if ($produit) {
                $dataPanier[] = [
                    'produit' => $produit,
                    'quantite' => $quantiter
                ];
                $total += $produit->getPrix() * $quantiter;
            }
        }


        return $this->render('panier/index.html.twig', [
            'items' => $dataPanier,
            'total' => $total
        ]);
    }

    #[Route('/add/{id}', name: 'add', methods: ['POST'])]
    public function add(int $id, Request $request): JsonResponse
    {
        
        $session = $request->getSession();
        
        
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        $totalQuantity = array_sum($panier);

        return $this->json([
            'message' => 'Produit ajouté !',
            'totalQuantity' => $totalQuantity
        ]);
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');
    }
}

