<?php

namespace App\Controller;

use App\Entity\ActiviteHotel;
use App\Entity\ActiviteRestaurant;
use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Entity\RenseignementIndividuelle;
use App\Entity\TypeActivite;
use App\Entity\TypeEtablissement;
use App\Form\ActiviteHotelType;
use App\Form\ActiviteRestaurantType;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Form\RenseignementIndividuelleType;
use App\Form\TypeActiviteType;
use App\Form\TypeEtablissementType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RenseignementIndividuController extends AbstractController
{
    #[Route('/AvisPrealable/Renseignement/Individu', name: 'affichage_RenseignementIndividu')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $renseignementIndividu = new RenseignementIndividuelle();


        $form = $this->createForm(RenseignementIndividuelleType::class, $renseignementIndividu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $renseignementIndividu->setUser($user);
            $entityManager->persist($renseignementIndividu);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_RenseignementIndividu'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/RenseignementIndividuelle.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
