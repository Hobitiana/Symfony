<?php

namespace App\Controller;

use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Entity\TypeEtablissement;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Form\TypeEtablissementType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeEtablissementController extends AbstractController
{
    #[Route('/AvisPrealable/TypeEtablssement/', name: 'affichage_TypeEtablissement')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $typeEtablissement = new TypeEtablissement();


        $form = $this->createForm(TypeEtablissementType::class, $typeEtablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $typeEtablissement->setUser($user);
            $entityManager->persist($typeEtablissement);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_TypeEtablissement'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/TypeEtablissement.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
