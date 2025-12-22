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

        $user = $this->getUser();
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        // Cas 1 : Nouvelle adresse via formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->addUser($user);
            $em->persist($adresse);
            return $this->processOrder($user, $adresse, $dataPanier, $em, $session);
        }

        // Cas 2 : Adresse existante sélectionnée
        if ($request->isMethod('POST') && $request->request->has('adresse_id')) {
            $adresseId = $request->request->get('adresse_id');
            $selectedAdresse = $em->getRepository(Adresse::class)->find($adresseId);

            if ($selectedAdresse && $selectedAdresse->getUsers()->contains($user)) {
                return $this->processOrder($user, $selectedAdresse, $dataPanier, $em, $session);
            }
        }

        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
            'items' => $dataPanier,
            'total' => $total,
            'user' => $user // Passer l'utilisateur pour afficher ses adresses
        ]);
    }

    private function processOrder($user, $adresse, $dataPanier, EntityManagerInterface $em, SessionInterface $session): Response
    {
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setAdresseLivraison($adresse);
        $commande->setStatus(StatusCommande::Preparation);
        $commande->setDate(new \DateTime());
        $commande->setReference(rand(100000, 999999));

        foreach ($dataPanier as $item) {
            /** @var \App\Entity\Produit $produit */
            $produit = $item['produit'];
            $commande->addProduit($produit);
            
            // Decrement stock
            $newStock = $produit->getStock() - $item['quantite'];
            $produit->setStock($newStock);
            
            $em->persist($produit);
        }

        $em->persist($commande);
        $em->flush();

        $session->remove('panier');

        return $this->redirectToRoute('commande_succes');
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
