<?php

namespace App\Controller;

use App\Entity\CategorieClassement;
use App\Entity\LieuImplantation;
use App\Form\CategorieClassementType;
use App\Form\LieuImplantationType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieClassementController extends AbstractController
{
    #[Route('/AvisPrealable/CategorieClassement/', name: 'affichage_CategorieClassement')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $categorieClassement = new CategorieClassement();

        $form = $this->createForm(CategorieClassementType::class, $categorieClassement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $categorieClassement->setUser($user);
            $entityManager->persist($categorieClassement);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_CategorieClassement'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/CategorieClassement.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
