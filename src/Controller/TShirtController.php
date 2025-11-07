<?php

namespace App\Controller;

use App\Repository\TShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TShirtController extends AbstractController
{
    #[Route('/t/shirt', name: 'app_t_shirt')]
    public function index(TShirtRepository $tShirtRepository): Response
    {
        $tshirts = $tShirtRepository->findAll();
        return $this->render('pantalon/index.html.twig', [
            'shorts' => $shorts,
        ]);
    }
}
