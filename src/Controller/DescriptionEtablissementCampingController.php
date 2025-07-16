<?php

namespace App\Controller;

use App\Entity\DescriptionCamping;
use App\Entity\DescriptionCampingDetail;
use App\Entity\DescriptionHebergement;
use App\Entity\DescriptionHebergementDetail;
use App\Entity\DescriptionQuestionCamping;
use App\Entity\DescriptionQuestionCampingDetail;
use App\Entity\DescriptionQuestionChoixCamping;
use App\Entity\DescriptionQuestionChoixCampingDetail;
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
use App\Entity\DescriptionTypeDeDemande;
use App\Entity\DesignationCamping;
use App\Entity\DesignationConstruction;
use App\Entity\DesignationHebergement;
use App\Entity\DesignationRestaurant;
use App\Entity\DesignationTypeModel;
use App\Entity\QuestionCamping;
use App\Entity\QuestionChoixCamping;
use App\Entity\QuestionChoixHebergement;
use App\Entity\QuestionChoixRestaurant;
use App\Entity\QuestionHebergement;
use App\Entity\QuestionRestaurant;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Form\DescriptionCampingType;
use App\Form\DescriptionChoixCampingType;
use App\Form\DescriptionHebergementType;
use App\Form\DescriptionQuestionCampingType;
use App\Form\DescriptionQuestionChoixHebergementType;
use App\Form\DescriptionQuestionChoixRestaurantType;
use App\Form\DescriptionQuestionHebergementType;
use App\Form\DescriptionQuestionRestaurantType;
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

class DescriptionEtablissementCampingController extends AbstractController
{
  
   

    #[Route('/AvisPrealable/Description/Camping', name: 'Affichage_DescriptionCamping')]
    public function restaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $description = new DescriptionCamping();

        // Get all designations from the database
        $designations = $entityManager->getRepository(DesignationCamping::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionCampingDetail();
            $detail->setDesignation($designation->getDesignation());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionCampingType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
            $entityManager->persist($description);
            $entityManager->flush();
            return $this->redirectToRoute('Affichage_DescriptionCamping'); // Adjust the redirect route as needed
        }

       
        return $this->render('AvisPrealable/DescriptionCamping.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/designation/Camping/success', name: 'designationCamping_success')]
    public function success(): Response
    {
        return new Response('Form submitted successfully!');
    }
    #[Route('/AvisPrealable/Description/Question/Camping', name: 'Affichage_QuestionDescriptionCamping')]
    public function questionRestaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $description = new DescriptionQuestionCamping();

        // Get all designations from the database
        $designations = $entityManager->getRepository(QuestionCamping::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionQuestionCampingDetail();
            $detail->setDesignation($designation->getQuestions());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionQuestionCampingType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
            $entityManager->persist($description);
            $entityManager->flush();
            return $this->redirectToRoute('Affichage_QuestionDescriptionCamping'); // Adjust the redirect route as needed
        }

       
        return $this->render('AvisPrealable/DescriptionQuestionCamping.html.twig', [
            'form' => $form->createView(),
        ]);
    }

 
    #[Route('/AvisPrealable/Description/QuestionChoix/Camping', name: 'Affichage_QuestionChoixDescriptionCamping')]
    public function questionChoixRestaurant(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $description = new DescriptionQuestionChoixCamping();

        // Get all designations from the database
        $designations = $entityManager->getRepository(QuestionChoixCamping::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new DescriptionQuestionChoixCampingDetail();
            $detail->setDesignation($designation->getQuestions());
            $description->addDetail($detail);
        }

        $form = $this->createForm(DescriptionChoixCampingType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $description->setUser($user);
            $entityManager->persist($description);
            $entityManager->flush();
            return $this->redirectToRoute('Affichage_QuestionChoixDescriptionCamping'); // Adjust the redirect route as needed
        }

       
        return $this->render('AvisPrealable/DescriptionQuestionChoixCamping.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
