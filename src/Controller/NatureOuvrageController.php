<?php

namespace App\Controller;

use App\Entity\LieuImplantation;
use App\Entity\NatureOuvrage;
use App\Entity\NatureProjet;
use App\Form\LieuImplantationType;
use App\Form\NatureOuvrageType;
use App\Form\NatureProjetType;
use App\Repository\DesignationConstructionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class NatureOuvrageController extends AbstractController
{
    #[Route('/AvisPrealable/NatureOuvrage/', name: 'affichage_NatureOuvrage')]
    public function index(HttpFoundationRequest $request,  SessionInterface $session, EtapeService $etapesService, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $natureOuvrage = new NatureOuvrage();


        $form = $this->createForm(NatureOuvrageType::class, $natureOuvrage);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape8');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('Affichage_TypeConstruction');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $natureOuvrage->setUser($user);
                //  $entityManager->persist($natureOuvrage);
                //$entityManager->flush();
                $dataNatureOuvrage = $form->getData();
                // Stocker les données dans la session
                $session->set('etape9', $dataNatureOuvrage);
                return $this->redirectToRoute('affichage_UploadFichier'); // Adjust the redirect route as needed
            }
        }
        return $this->render('AvisPrealable/NatureOuvrage.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 9,
        ]);
    }
}
