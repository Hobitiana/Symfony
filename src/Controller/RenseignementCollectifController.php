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
        $renseignementVisa = new RenseignementVisa();

        // Créer le formulaire combiné
        $formCIN = $this->createForm(RenseignementCINType::class, $renseignementCIN);
        $formCIN->handleRequest($request);
        $formVisa = $this->createForm(RenseignementVisaType::class, $renseignementVisa);
        $formVisa->handleRequest($request);


        if ($formCIN->isSubmitted() && $formCIN->isValid() ) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté

            // Associer l'utilisateur aux entités
            $renseignementCIN->setUser($user);
            $renseignementVisa->setUser($user);

            // Persister les entités
            $entityManager->persist($renseignementCIN);
            $entityManager->persist($renseignementVisa);
            $entityManager->flush();

            // Redirection après soumission
            return $this->redirectToRoute('affichage_RenseignementCollectif');
        }

        return $this->render('AvisPrealable/RenseignementCollectif.html.twig', [
            'formCIN' => $formCIN->createView(),
            'formVisa' => $formVisa->createView(),
        ]);
    }
}
