<?php

namespace App\Controller;

use App\Repository\ShortRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShortController extends AbstractController
{
    #[Route('/short', name: 'app_short')]
    public function index(ShortRepository $shortRepository): Response
    {
        $shorts = $shortRepository->findAll();
        return $this->render('pantalon/index.html.twig', [
            'shorts' => $shorts,
        ]);
    }
}
