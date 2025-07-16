<?php

namespace App\Controller;

use App\Entity\DescriptionHebergement;
use App\Entity\DescriptionHebergementDetail;
use App\Entity\DescriptionQuestionChoixHebergement;
use App\Entity\DescriptionQuestionChoixHebergementDetail;
use App\Entity\DescriptionQuestionChoixRestaurant;
use App\Entity\DescriptionQuestionChoixRestaurantDetail;
use App\Entity\DescriptionQuestionHebergement;
use App\Entity\DescriptionQuestionHebergementDetail;
use App\Entity\DescriptionQuestionRestaurant;
use App\Entity\DescriptionQuestionRestaurantDetail;
use App\Entity\DescriptionRestaurant;
use App\Entity\DescriptionRestaurantDetail;
use App\Entity\DescriptionEquipementRestaurantDetail;
use App\Entity\DescriptionTypeDeDemande;
use App\Entity\DesignationConstruction;
use App\Entity\DesignationHebergement;
use App\Entity\DesignationRestaurant;
use App\Entity\DesignationEquipementRestaurant;
use App\Entity\DesignationTypeModel;
use App\Entity\QuestionChoixHebergement;
use App\Entity\QuestionChoixRestaurant;
use App\Entity\QuestionHebergement;
use App\Entity\QuestionRestaurant;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Entity\DescriptionEquipementRestaurant;
use App\Form\DescriptionHebergementType;
use App\Form\DescriptionQuestionChoixHebergementType;
use App\Form\DescriptionQuestionChoixRestaurantType;
use App\Form\DescriptionQuestionHebergementType;
use App\Form\DescriptionQuestionRestaurantType;
use App\Form\DescriptionEquipementRestaurantType;
use App\Form\DescriptionRestaurantType;
use App\Form\DescriptionTypeDeDemandeType;
use App\Form\TypeConstructionType;
use App\Repository\DescriptionTypeDeDemandeRepository;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\DateService;
use App\Service\EtapeService;
use App\Entity\ResponsableDemande;

class DescriptionEtablissementRestaurantController extends AbstractController
{
  
   

    #[Route('/AvisPrealable/Description/Restaurant', name: 'Affichage_DescriptionRestaurant')]
    public function restaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo,EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionRestaurant();

        // Get all designations from the database
        $designations = $entityManager->getRepository(DesignationRestaurant::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionRestaurantDetail();
            $detail->setDesignation($designation->getDesignation());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionRestaurantType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape12');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_CateorieClassement');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
           // $entityManager->persist($description);
          //  $entityManager->flush();

            $dataDescription = $form->getData();
            // Stocker les données dans la session
            $session->set('etape13', $dataDescription);
            return $this->redirectToRoute('Affichage_QuestionDescriptionRestaurant'); // Adjust the redirect route as needed
        }

    }
        return $this->render('AvisPrealable/DescriptionRestaurant.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 13,
        ]);
    }

    #[Route('/designation/Restaurant/success', name: 'designationRestaurant_success')]
    public function success(): Response
    {
        return new Response('Form submitted successfully!');
    }
    #[Route('/AvisPrealable/Description/Question/Restaurant', name: 'Affichage_QuestionDescriptionRestaurant')]
    public function questionRestaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo,EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionQuestionRestaurant();

        // Get all designations from the database
        $designations = $entityManager->getRepository(QuestionRestaurant::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionQuestionRestaurantDetail();
            $detail->setDesignation($designation->getQuestions());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionQuestionRestaurantType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape13');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('Affichage_DescriptionRestaurant');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
          //  $entityManager->persist($description);
          //  $entityManager->flush();

            $dataDescription = $form->getData();
            // Stocker les données dans la session
            $session->set('etape14', $dataDescription);
            return $this->redirectToRoute('Affichage_QuestionChoixDescriptionRestaurant'); // Adjust the redirect route as needed
        }

    }
        return $this->render('AvisPrealable/DescriptionQuestionRestaurant.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 14,
        ]);
    }

 
    #[Route('/AvisPrealable/Description/QuestionChoix/Restaurant', name: 'Affichage_QuestionChoixDescriptionRestaurant')]
    public function questionChoixRestaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo,EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionQuestionChoixRestaurant();

        // Get all designations from the database
        $designations = $entityManager->getRepository(QuestionChoixRestaurant::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionQuestionChoixRestaurantDetail();
            $detail->setDesignation($designation->getQuestions());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionQuestionChoixRestaurantType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape14');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_CateorieClassement');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
           // $entityManager->persist($description);
           // $entityManager->flush();

            return $this->redirectToRoute('Affichage_typeDeDemandeRestaurant'); // Adjust the redirect route as needed
        }
    }
       
        return $this->render('AvisPrealable/DescriptionQuestionChoixRestaurant.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 15,
        ]);
    }
    #[Route('/AvisPrealable/Description/Restaurant/typeDeDemande', name: 'Affichage_typeDeDemandeRestaurant')]
    public function typeDeDemande(Request $request, EntityManagerInterface $entityManager, DescriptionTypeDeDemandeRepository $designationRepo,EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionTypeDeDemande();

        try {
            // Récupérer les données via EntityManager
            $designations = $entityManager->getRepository(DesignationTypeModel::class)->findAll();
            $form = $this->createForm(DescriptionTypeDeDemandeType::class, $description);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $action = $request->get('action'); // Récupérer le bouton cliqué

                if ($action === 'back') {
                    // Supprimer les données de session pour cette étape
                    $session->remove('etape13');

                    // Rediriger vers l'étape précédente
                    return $this->redirectToRoute('affichage_CateorieClassement');
                }

                // Si le bouton "Suivant" est cliqué, valider le formulaire
                if ($action === 'next' &&  $form->isValid()) {
                    $user = $this->getUser();
                    $description->setUser($user);



                    $dataDescription = $form->getData();
                    // Stocker les données dans la session
                    $session->set('etape16', $dataDescription);
                    return $this->redirectToRoute('enregistrement_mes_donnees');
                }
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

    return $this->render('AvisPrealable/DescriptionTypeDeDemande.html.twig', [
        'designations' => $designations,
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 16,
    ]);
    }

    #[Route('/AvisPrealable/Description/Equipement/Restaurant', name: 'Affichage_DescriptionEquipementRestaurant')]
    public function equipementRestaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo,EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionEquipementRestaurant();

        // Get all designations from the database
        $designations = $entityManager->getRepository(DesignationEquipementRestaurant::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionEquipementRestaurantDetail();
            $detail->setDesignation($designation->getDesignation());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionEquipementRestaurantType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
            $entityManager->persist($description);
            $entityManager->flush();
            return $this->redirectToRoute('Affichage_DescriptionEquipementRestaurant'); // Adjust the redirect route as needed
        }

       
        return $this->render('AvisPrealable/DescriptionEquipementRestaurant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
