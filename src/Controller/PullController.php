<?php

namespace App\Controller;

use App\Repository\PullRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PullController extends AbstractController
{
    #[Route('/pull', name: 'app_pull')]
    public function index(PullRepository $pullRepository): Response
    {
        $pulls = $pullRepository->findAll();
        return $this->render('pantalon/index.html.twig', [
            'pulls' => $pulls,
        ]);
    }
}
