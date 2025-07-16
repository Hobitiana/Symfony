<?php

namespace App\Controller;

use App\Entity\CategorieClassement;
use App\Entity\GroupeActivite;
use App\Entity\LieuImplantation;
use App\Entity\RelationActivite;
use App\Form\CategorieClassementType;
use App\Form\LieuImplantationType;
use App\Repository\DesignationConstructionRepository;
use App\Repository\DesignationRestaurantRepository;
use App\Repository\GroupeActiviteRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CategorieClassementController extends AbstractController
{
    #[Route('/AvisPrealable/CategorieClassement/', name: 'affichage_CategorieClassement')]
    public function index(HttpFoundationRequest $request, SessionInterface $session, EtapeService $etapesService, EntityManagerInterface $entityManager, GroupeActiviteRepository $groupeActiviteRepo): Response
    {
        $categorieClassement = new CategorieClassement();

        $form = $this->createForm(CategorieClassementType::class, $categorieClassement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape11');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_UploadFichier');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $categorieClassement->setUser($user);
                //  $entityManager->persist($categorieClassement);
                //$entityManager->flush();
                $dataCategorieClassement = $form->getData();
                // Stocker les données dans la session
                $session->set('etape12', $dataCategorieClassement);
                // dd($session->get('etape12'));
                $relationActivite =  $session->get('etape5');
                // Récupérer l'objet RelationActivite depuis la session

                $nomGroupe = $relationActivite->getNomGroupe(); // Utiliser le getter
                // Afficher ou utiliser la valeur
                //dd($nomGroupe);
                // Vérifier si l'objet existe dans la session
                /*
                $groupeActivite = $groupeActiviteRepo->findGroupeActiviteByUser($user);

                if ($groupeActivite) {
                    $activite = $groupeActivite->getActivite(); 
                    */

                if ($nomGroupe == "Hebergement") {
                    return $this->redirectToRoute('Affichage_DescriptionHebergement');
                }
                if ($nomGroupe == "Restauration") {
                    return $this->redirectToRoute('Affichage_DescriptionRestaurant');
                }
                if ($nomGroupe == "Camping") {
                    return $this->redirectToRoute('Affichage_DescriptionCamping');
                }
                /*   } */
                //dd($session->get('etape11'));
                // dd($session->get('etape10'));
                //dd($session->get('etape9'));
                //dd($session->get('etape8'));
                //dd($session->get('etape3'));

                return $this->redirectToRoute('affichage_CategorieClassement'); // Adjust the redirect route as needed
            }
        }
        return $this->render('AvisPrealable/CategorieClassement.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 12,
        ]);
    }
}
