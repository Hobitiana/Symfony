<?php

namespace App\Controller;

use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NatureProjetController extends AbstractController
{
    #[Route('/AvisPrealable/NatureProjet/', name: 'affichage_NatureProjet')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $natureProjet = new NatureProjet();


        $form = $this->createForm(NatureProjetType::class, $natureProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $natureProjet->setUser($user);
            $entityManager->persist($natureProjet);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_NatureProjet'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/NatureProjet.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
