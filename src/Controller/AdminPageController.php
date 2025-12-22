<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminPageController extends AbstractController
{
    #[Route('/admin', name: 'app_adminPage_index')]
    public function index(): Response
    {

        return $this->render('adminPage/index.html.twig', [
        ]);
    }
}