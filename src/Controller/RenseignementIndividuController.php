<?php

namespace App\Controller;

use App\Entity\ActiviteHotel;
use App\Entity\ActiviteRestaurant;
use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Entity\RenseignementIndividuelle;
use App\Entity\TypeActivite;
use App\Entity\Nationalite;
use App\Entity\TypeEtablissement;
use App\Form\ActiviteHotelType;
use App\Form\ActiviteRestaurantType;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Form\RenseignementIndividuelleType;
use App\Form\TypeActiviteType;
use App\Form\TypeEtablissementType;
use App\Repository\DesignationConstructionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class RenseignementIndividuController extends AbstractController
{
    #[Route('/AvisPrealable/Renseignement/Individu', name: 'affichage_RenseignementIndividu')]
    public function index(HttpFoundationRequest $request, SessionInterface $session,  EtapeService $etapesService, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        // $renseignementIndividu = new RenseignementIndividuelle();


        // $form = $this->createForm(RenseignementIndividuelleType::class, $renseignementIndividu);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $user = $this->getUser(); // Récupère l'utilisateur connecté
        //     $renseignementIndividu->setUser($user);
        //     $entityManager->persist($renseignementIndividu);
        //     $entityManager->flush();
        //     return $this->redirectToRoute('affichage_RenseignementResponsable'); // Adjust the redirect route as needed
        // }
        // return $this->render('AvisPrealable/RenseignementIndividuelle.html.twig', [
        //     'form' => $form->createView(),
        // ]);
        $renseignementIndividu = new RenseignementIndividuelle();

        $form = $this->createForm(RenseignementIndividuelleType::class, $renseignementIndividu);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape1');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_RenseignementTypeEntreprise');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $renseignementIndividu->setUser($user);

                //$entityManager->persist($renseignementIndividu);
                // $entityManager->flush();

                $dataRenseignementIndividu = $form->getData();
                // Stocker les données dans la session
                $session->set('etape2', $dataRenseignementIndividu);
                // $dataRenseignementIndividu = $session->get('etape2');

                $nationalite = $renseignementIndividu->getNationalite();
                // var_dump($nationalite);
                $nat = $nationalite->getNomNationalite();

                if ($nat == "Malagasy") {
                    return $this->redirectToRoute('affichage_RenseignementCollectif');
                }
                return $this->redirectToRoute('affichage_RenseignementCollectifvisa'); // Adjust the redirect route as needed
            }
        }
        return $this->render('AvisPrealable/RenseignementIndividuelle.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 2,
        ]);
    }
}
