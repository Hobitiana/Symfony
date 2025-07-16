<?php

namespace App\Controller;

use App\Entity\RenseignementCIN;
use App\Entity\RenseignementVisa;
use App\Form\RenseignementCINType;
use App\Form\RenseignementVisaType;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RenseignementCollectifController extends AbstractController
{
    #[Route('/AvisPrealable/Renseignement/Collectif', name: 'affichage_RenseignementCollectif')]
    public function index(Request $request, SessionInterface $session, EtapeService $etapesService, EntityManagerInterface $entityManager): Response
    {
        // Créer les entités
        $renseignementCIN = new RenseignementCIN();

        // Créer le formulaire combiné
        $formCIN = $this->createForm(RenseignementCINType::class, $renseignementCIN);
        $formCIN->handleRequest($request);
        //  dd($formCIN->isSubmitted());
        if ($formCIN->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué
            // dd($action);
            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape2');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_RenseignementIndividu');
            }

            //dd($formCIN->isValid());
            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next') {
                $user = $this->getUser(); // Récupère l'utilisateur connecté

                // Associer l'utilisateur aux entités
                $renseignementCIN->setUser($user);

                // Persister les entités
                //$entityManager->persist($renseignementCIN);
                //$entityManager->flush();
                $dataRenseignementCIN = $formCIN->getData();
                // dd($dataRenseignementCIN);
                // Stocker les données dans la session
                $session->set('etape3CIN', $dataRenseignementCIN);
                // Redirection après soumission
                return $this->redirectToRoute('affichage_NatureProjet');
            }
        }
        return $this->render('AvisPrealable/RenseignementCollectif.html.twig', [
            'formCIN' => $formCIN->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 3,
        ]);
    }
    #[Route('/AvisPrealable/Renseignement/Collectifvisa', name: 'affichage_RenseignementCollectifvisa')]
    public function index1(Request $request, SessionInterface $session, EtapeService $etapesService, EntityManagerInterface $entityManager): Response
    {

        $renseignementVisa = new RenseignementVisa();

        $formVisa = $this->createForm(RenseignementVisaType::class, $renseignementVisa);
        $formVisa->handleRequest($request);
        if ($formVisa->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape2');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_RenseignementIndividu');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $formVisa->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté


                $renseignementVisa->setUser($user);

                // $entityManager->persist($renseignementVisa);
                // $entityManager->flush();
                $dataRenseignementVisa = $formVisa->getData();
                // Stocker les données dans la session
                $session->set('etape3Visa', $dataRenseignementVisa);
                // Redirection après soumission
                return $this->redirectToRoute('affichage_NatureProjet');
            }
        }
        return $this->render('AvisPrealable/RenseignementCollectifVisa.html.twig', [
            'formVisa' => $formVisa->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 3,
        ]);
    }
}
