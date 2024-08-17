<?php

namespace App\Controller;

use App\Entity\GroupeActivite;
use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Entity\TypeActivite;
use App\Entity\TypeEtablissement;
use App\Form\GroupeActiviteType;
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

class GroupeActiviteController extends AbstractController
{
    #[Route('/AvisPrealable/GroupeActivite/', name: 'affichage_GroupeActivite')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $groupeActivite = new GroupeActivite();


        $form = $this->createForm(GroupeActiviteType::class, $groupeActivite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $groupeActivite->setUser($user);
            
            $entityManager->persist($groupeActivite);
            $entityManager->flush();

            $savedActivite = $groupeActivite->getActivite();
            if($savedActivite == "Hotel")
            {
              return $this->redirectToRoute('affichage_ActiviteHotel');
            }
            if($savedActivite == "Restaurant")
            {
              return $this->redirectToRoute('affichage_ActiviteRestaurant');
            }
            if($savedActivite == "Camping")
            {
              return $this->redirectToRoute('affichage_ActiviteCamping');
            }
            return $this->redirectToRoute('affichage_GroupeActivite'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/GroupeActivite.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
