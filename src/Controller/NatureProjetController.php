<?php

namespace App\Controller;

use App\Entity\LieuImplantation;
use App\Entity\NatureProjet;
use App\Form\LieuImplantationType;
use App\Form\NatureProjetType;
use App\Repository\DesignationConstructionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class NatureProjetController extends AbstractController
{
    #[Route('/AvisPrealable/NatureProjet/', name: 'affichage_NatureProjet')]
    public function index(HttpFoundationRequest $request, EtapeService $etapesService, SessionInterface $session, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $natureProjet = new NatureProjet();
        $form = $this->createForm(NatureProjetType::class, $natureProjet);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape

                if (is_null($session->get('etape3CIN'))) {
                    $session->remove('etape3Visa');
                    return $this->redirectToRoute('affichage_RenseignementCollectifvisa');
                }
                $session->remove('etape3CIN');
                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_RenseignementCollectif');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $natureProjet->setUser($user);
                // $entityManager->persist($natureProjet);
                // $entityManager->flush();

                $dataNatureProjet = $form->getData();
                // Stocker les données dans la session
                $session->set('etape4', $dataNatureProjet);
                return $this->redirectToRoute('Affiche_GroupeActivite1'); // Adjust the redirect route as needed
            }
        }
        return $this->render('AvisPrealable/NatureProjet.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 4,
        ]);
    }
}
