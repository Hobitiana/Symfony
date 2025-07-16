<?php

namespace App\Controller;

use App\Entity\Environnement;
use App\Form\EnvironnementType;
use App\Repository\DesignationConstructionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class EnvironnementController extends AbstractController
{

    #[Route('/AvisPrealable/Environnement/', name: 'affichage_Environnement')]
    public function index(HttpFoundationRequest $request, EtapeService $etapesService, SessionInterface $session, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $environnement = new Environnement();


        $form = $this->createForm(EnvironnementType::class, $environnement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape6');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('Affiche_Lieu');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $environnement->setUser($user);
                //  $entityManager->persist($environnement);
                //$entityManager->flush();
                $dataEnvironnement = $form->getData();
                // Stocker les données dans la session
                $session->set('etape7', $dataEnvironnement);

                return $this->redirectToRoute('Affichage_TypeConstruction'); // Adjust the redirect route as needed
            }
        }
        return $this->render('AvisPrealable/Environnement.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 7,
        ]);
    }
}
