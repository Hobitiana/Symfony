<?php

namespace App\Controller;

use App\Entity\LieuImplantation;
use App\Form\LieuImplantationType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LieuImplantationController extends AbstractController
{
    #[Route('/AvisPrealable/LieuImplantation/', name: 'affichage_LieuImplantation')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $lieuImplantation = new LieuImplantation();


        $form = $this->createForm(LieuImplantationType::class, $lieuImplantation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $lieuImplantation->setUser($user);
            $entityManager->persist($lieuImplantation);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_LieuImplantation'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/LieuImplantation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
