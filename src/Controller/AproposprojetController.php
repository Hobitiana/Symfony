<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AproposprojetController extends AbstractController
{
    #[Route('/aproposprojet', name: 'app_aproposprojet')]
    public function index(): Response
    {
        return $this->render('aproposprojet/index.html.twig', [
            'controller_name' => 'AproposprojetController',
        ]);
    }
    #[Route('/apropos-du-site', name: 'app_apropospros_site')]
    public function apropos(): Response
    {
        return $this->render('contact/apropos.html.twig');
    }
}
