<?php

namespace App\Controller;

use App\Entity\Pantalon;
use App\Repository\PantalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PantalonController extends AbstractController
{
    #[Route('/pantalon', name: 'app_pantalon')]
    public function index(PantalonRepository $pantalonRepository): Response
    {
        $pantalons = $pantalonRepository->findAll();
        return $this->render('pantalon/index.html.twig', [
            'pantalons' => $pantalons,
        ]);
    }

    #[Route('/vue/{id}', name: 'id')]
    public function show(int $id, Pantalon $pantalon): Response
    {
        return $this->render('burger/show.html.twig', parameters:[
            'pantalon' => $pantalon
        ]);
    }

    #[Route('/pantalon/create', name: 'pantalon_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $pantalon = new Pantalon();
        $pantalon->setNom('BLACK RALLY DENIM');
        $pantalon->setPrix(109.95);
        $pantalon->setTaille(40);
        $pantalon->setMarque("DIVIN BY DIVIN");
    
        // Persister et sauvegarder le nouveau pantalon
        $entityManager->persist($pantalon);
        $entityManager->flush();
    
        return new Response('Pantalon créé avec succès !');
    }
}
