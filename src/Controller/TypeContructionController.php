<?php

namespace App\Controller;

use App\Entity\DesignationConstruction;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Form\TypeConstructionType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class TypeContructionController extends AbstractController
{
  
   

    #[Route('/TypeDeConstruction/new', name: 'Affichage_TypeConstruction')]
    public function new(Request $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $typeConstruction = new TypeConstruction();

        // Get all designations from the database
        $designations = $entityManager->getRepository(DesignationConstruction::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new TypeConstructionDetail();
            $detail->setDesignation($designation->getDesignation());
            $typeConstruction->addDetail($detail);
        }

        $form = $this->createForm(TypeConstructionType::class, $typeConstruction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $typeConstruction->setUser($user);
            $entityManager->persist($typeConstruction);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_NatureOuvrage'); // Adjust the redirect route as needed
        }

       
        return $this->render('AvisPrealable/TypeConstruction.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/designation/success', name: 'designation_success')]
    public function success(): Response
    {
        return new Response('Form submitted successfully!');
    }
}
