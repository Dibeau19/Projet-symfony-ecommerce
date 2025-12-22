<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\CarteCredit;
use App\Entity\Commande;
use App\Enum\StatusCommande;
use App\Form\AdresseType;
use App\Form\CarteCreditType;
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

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $adresse = new Adresse();
        $adresseForm = $this->createForm(AdresseType::class, $adresse);

        $carteCredit = new CarteCredit();
        $carteForm = $this->createForm(CarteCreditType::class, $carteCredit);

        if ($request->isMethod('POST')) {

            $selectedAdresse = null;
            $selectedCarte = null;
            $adresseId = $request->request->get('adresse_id');
            $carteId = $request->request->get('carte_id');

            if ($adresseId === 'new' || (!$adresseId && $user->getAdresses()->isEmpty())) {
                 $adresseForm->handleRequest($request);
                 if ($adresseForm->isSubmitted() && $adresseForm->isValid()) {
                    $adresse->addUser($user);
                    $em->persist($adresse);
                    $selectedAdresse = $adresse;
                 }
            } elseif ($adresseId) {
                $selectedAdresse = $em->getRepository(Adresse::class)->find($adresseId);
            }

            if ($carteId === 'new' || (!$carteId && $user->getCartesCredit()->isEmpty())) {
                $carteForm->handleRequest($request);
                if ($carteForm->isSubmitted() && $carteForm->isValid()) {
                    $carteCredit->setUser($user);
                    $em->persist($carteCredit);
                    $selectedCarte = $carteCredit;
                }
            } elseif ($carteId) {
                $selectedCarte = $em->getRepository(CarteCredit::class)->find($carteId);
            }

            if ($selectedAdresse && $selectedCarte) {
                if ($selectedAdresse->getUsers()->contains($user) && $selectedCarte->getUser() === $user) {
                    return $this->processOrder($user, $selectedAdresse, $dataPanier, $em, $session);
                }
            }
        }

        return $this->render('commande/index.html.twig', [
            'form' => $adresseForm->createView(),
            'carteForm' => $carteForm->createView(),
            'items' => $dataPanier,
            'total' => $total,
            'user' => $user
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
