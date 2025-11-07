<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        $user = $this->getUser();

        return $this->render('home/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/remove/{id}', name: 'produit_remove')]
    public function delete(EntityManagerInterface $entityManager, Produit $produit){
        $entityManager->remove($produit);
        $entityManager->flush();

        return new Response('Produit suppimé avec succès');
    }
}
