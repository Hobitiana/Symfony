<?php

namespace App\Controller;

use App\Entity\Environnement;
use App\Form\EnvironnementType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnvironnementController extends AbstractController
{

    #[Route('/AvisPrealable/Environnement/', name: 'affichage_Environnement')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $environnement = new Environnement();


        $form = $this->createForm(EnvironnementType::class, $environnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $environnement->setUser($user);
            $entityManager->persist($environnement);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_Environnement'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/Environnement.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
