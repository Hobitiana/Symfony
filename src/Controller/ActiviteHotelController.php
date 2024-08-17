<?php

namespace App\Controller;

use App\Entity\ActiviteHotel;
use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Entity\TypeActivite;
use App\Entity\TypeEtablissement;
use App\Form\ActiviteHotelType;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Form\TypeActiviteType;
use App\Form\TypeEtablissementType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActiviteHotelController extends AbstractController
{
    #[Route('/AvisPrealable/ActiviteHotel/', name: 'affichage_ActiviteHotel')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $typeActivite = new ActiviteHotel();


        $form = $this->createForm(ActiviteHotelType::class, $typeActivite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $typeActivite->setUser($user);
            $entityManager->persist($typeActivite);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_ActiviteHotel'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/TypeActivite.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
