<?php

namespace App\Controller;

use App\Entity\ActiviteHotel;
use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Entity\RenseignementEntreprise;
use App\Entity\RenseignementResponsable;
use App\Entity\RenseignementTypeEntreprise;
use App\Entity\TypeActivite;
use App\Entity\TypeEtablissement;
use App\Form\ActiviteHotelType;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Form\RenseignementChoixEntrepriseType;
use App\Form\RenseignementEntrepriseType;
use App\Form\RenseignementResponsableType;
use App\Form\TypeActiviteType;
use App\Form\TypeEtablissementType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EtapeService;

class RenseignementController extends AbstractController
{
    #[Route('/AvisPrealable/Renseignement/Entreprise', name: 'affichage_RenseignementEntreprise')]
    public function renseignementEntreprise(HttpFoundationRequest $request, SessionInterface $session, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $renseignementEntreprise = new RenseignementEntreprise();


        $form = $this->createForm(RenseignementEntrepriseType::class, $renseignementEntreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $renseignementEntreprise->setUser($user);
            $entityManager->persist($renseignementEntreprise);
            $entityManager->flush();

            // $dataEntreprise = $form->getData();
            // Stocker les données dans la session
            //  $session->set('etape1', $dataEntreprise);

            return $this->redirectToRoute('affichage_RenseignementEntreprise'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/RenseignementEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/AvisPrealable/Renseignement/Responsable', name: 'affichage_RenseignementResponsable')]
    public function renseignementResponsable(HttpFoundationRequest $request, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $renseignementResponsable = new RenseignementResponsable();


        $form = $this->createForm(RenseignementResponsableType::class, $renseignementResponsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $renseignementResponsable->setUser($user);
            $entityManager->persist($renseignementResponsable);
            $entityManager->flush();


            return $this->redirectToRoute('affichage_RenseignementResponsable'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/RenseignementResponsable.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/AvisPrealable/Renseignement/Type/Entreprise', name: 'affichage_RenseignementTypeEntreprise')]
    public function renseignementTypeEntreprise(HttpFoundationRequest $request, SessionInterface $session, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo, EtapeService $etapesService): Response
    {
        $renseignementTypeEntreprise = new RenseignementTypeEntreprise();


        $form = $this->createForm(RenseignementChoixEntrepriseType::class, $renseignementTypeEntreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $renseignementTypeEntreprise->setUser($user);
            //  $entityManager->persist($renseignementTypeEntreprise);
            //  $entityManager->flush();

            $dataEntreprise = $form->getData();
            // Stocker les données dans la session
            $session->set('etape1', $dataEntreprise);
            $dataEntreprise = $session->get('etape1');
            //dd($dataEntreprise);
            $savedTypeEntreprise = $dataEntreprise->getTypeEntrprise();
            if ($savedTypeEntreprise == "Individuelle") {
                return $this->redirectToRoute('affichage_RenseignementIndividu');
            }
            return $this->redirectToRoute('app_entreprise');
        }
        return $this->render('AvisPrealable/RenseignementEntreprise.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 1,
        ]);
    }
}
