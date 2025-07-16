<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MapController extends AbstractController
{
    #[Route('/map-madagascar', name: 'affichage_madagascar')]
    public function index(): Response
    {
        return $this->render('accueil/mapMadagascar.html.twig');
    }

   
    

  
}
