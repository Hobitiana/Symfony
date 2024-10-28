<?php

namespace App\Controller;

use App\Entity\RenseignementCIN;
use App\Entity\RenseignementVisa;
use App\Form\RenseignementCINType;
use App\Form\RenseignementVisaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RenseignementCollectifController extends AbstractController
{
    #[Route('/AvisPrealable/Renseignement/Collectif', name: 'affichage_RenseignementCollectif')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer les entités
        $renseignementCIN = new RenseignementCIN();

        // Créer le formulaire combiné
        $formCIN = $this->createForm(RenseignementCINType::class, $renseignementCIN);
        $formCIN->handleRequest($request);


        if ($formCIN->isSubmitted() && $formCIN->isValid() ) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté

            // Associer l'utilisateur aux entités
            $renseignementCIN->setUser($user);

            // Persister les entités
            $entityManager->persist($renseignementCIN);
            $entityManager->flush();

            // Redirection après soumission
            return $this->redirectToRoute('affichage_NatureProjet');
        }

        return $this->render('AvisPrealable/RenseignementCollectif.html.twig', [
            'formCIN' => $formCIN->createView(),
        ]);
    }
    #[Route('/AvisPrealable/Renseignement/Collectifvisa', name: 'affichage_RenseignementCollectifvisa')]
    public function index1(Request $request, EntityManagerInterface $entityManager): Response
    {

        $renseignementVisa = new RenseignementVisa();

        $formVisa = $this->createForm(RenseignementVisaType::class, $renseignementVisa);
        $formVisa->handleRequest($request);


        if ($formVisa->isSubmitted() && $formVisa->isValid() ) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté


            $renseignementVisa->setUser($user);

            $entityManager->persist($renseignementVisa);
            $entityManager->flush();

            // Redirection après soumission
            return $this->redirectToRoute('affichage_NatureProjet');
        }

        return $this->render('AvisPrealable/RenseignementCollectifVisa.html.twig', [
            'formVisa' => $formVisa->createView(),
        ]);
    }
}
