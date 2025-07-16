<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypedemandeController extends AbstractController
{
    #[Route('/typedemande', name: 'app_typedemande')]
    public function index(): Response
    {
        return $this->render('typedemande/index.html.twig', [
            'controller_name' => 'TypedemandeController',
        ]);
    }
}
