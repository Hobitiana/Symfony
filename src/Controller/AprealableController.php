<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AprealableController extends AbstractController
{
    #[Route('/aprealable', name: 'app_aprealable')]
    public function index(): Response
    {
        return $this->render('aprealable/index.html.twig', [
            'controller_name' => 'AprealableController',
        ]);
    }
}
