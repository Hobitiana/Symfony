<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ResultatDemandeRepository;

class DashboardController extends AbstractController
{
    
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ResultatDemandeRepository $resultatDemandeRepository): Response
    {
     // Vérifie si l'utilisateur est authentifié
    if (!$this->getUser()) {
        throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
    }
    $user = $this->getUser();
    $demandes = $resultatDemandeRepository->findBy(['user' => $user]);

    return $this->render('accueil/mapMadagascar.html.twig');
    }

      /*  
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        // Vérifie si l'utilisateur est authentifié
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        return $this->render('dashboard/index.html.twig');
    }*/
}
