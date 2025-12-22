<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Enum\StatusCommande;
use App\Form\AdresseType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande', name: 'commande_')]
final class CommandeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $panier = $session->get('panier', []);

        if (empty($panier)) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('panier_index');
        }

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

        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $adresse->addUser($user);

            $commande = new Commande();
            $commande->setUser($user);
            $commande->setAdresseLivraison($adresse);
            $commande->setStatus(StatusCommande::Preparation);
            $commande->setDate(new \DateTime());

            // Generating a reference manually since not an ID (simplification)
            // Assuming reference is int based on entity definition
            $commande->setReference(rand(100000, 999999));

            foreach ($dataPanier as $item) {
                $commande->addProduit($item['produit']);
            }

            $em->persist($adresse);
            $em->persist($commande);
            $em->flush();

            $session->remove('panier');

            return $this->redirectToRoute('commande_succes');
        }

        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
            'items' => $dataPanier,
            'total' => $total
        ]);
    }

    #[Route('/succes', name: 'succes')]
    public function succes(): Response
    {
        return $this->render('commande/succes.html.twig');
    }
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Commande $commande): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/admin', name: 'admin')]
    public function admin(CommandeRepository $commandeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $query = $commandeRepository->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();

        $commandes = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('commande/adminIndex.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
