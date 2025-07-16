<?php

namespace App\Controller;

use App\Entity\DesignationConstruction;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Form\TypeConstructionType;
use App\Repository\DesignationConstructionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TypeContructionController extends AbstractController
{



    #[Route('/TypeDeConstruction/new', name: 'Affichage_TypeConstruction')]
    public function new(Request $request, SessionInterface $session, EtapeService $etapesService, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $typeConstruction = new TypeConstruction();

        // Get all designations from the database
        $designations = $entityManager->getRepository(DesignationConstruction::class)->findAll();

        foreach ($designations as $designation) {
            $detail = new TypeConstructionDetail();
            $detail->setDesignation($designation->getDesignation());
            $typeConstruction->addDetail($detail);
        }

        $form = $this->createForm(TypeConstructionType::class, $typeConstruction);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape7');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_Environnement');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $typeConstruction->setUser($user);
                // $entityManager->persist($typeConstruction);
                //$entityManager->flush();
                $dataTypeConstruction = $form->getData();
                // Stocker les données dans la session
                $session->set('etape8', $dataTypeConstruction);

                return $this->redirectToRoute('affichage_NatureOuvrage'); // Adjust the redirect route as needed
            }
        }

        return $this->render('AvisPrealable/TypeConstruction.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 8,
        ]);
    }

    #[Route('/designation/success', name: 'designation_success')]
    public function success(): Response
    {
        return new Response('Form submitted successfully!');
    }
}
