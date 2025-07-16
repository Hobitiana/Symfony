<?php

namespace App\Controller;

use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Form\LieuImplantationType;
use App\Form\NatureDeDemandeType;
use App\Form\NatureProjetType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NatureDeDemandeController extends AbstractController
{
    #[Route('/NouvelleDemande/NatureDeDemande/', name: 'affichage_NatureDeDeamnde')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $natureProjet = new NatureProjet();


        $form = $this->createForm(NatureDeDemandeType::class);
        $form->handleRequest($request);
        $activite = null; // Initialise la variable

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la valeur sélectionnée
            $activite = $form->get('activite')->getData();
//var_dump($activite);
//die;
            // Affiche la valeur pour vérifier
            var_dump($activite);
            if(  $activite == "Avis Prealable") {
                return $this->redirectToRoute('affichage_RenseignementTypeEntreprise');
            }
            if(  $activite == "Avis d'Ouverture") {
                return $this->redirectToRoute('app_reference');
            }
            if(  $activite == "Avis Ouverture Licence") {
                return $this->redirectToRoute('affichage_AvisOuverture');
            }
        }

        return $this->render('AvisPrealable/NatureDeDemande.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
