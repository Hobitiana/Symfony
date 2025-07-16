<?php

namespace App\Controller\AvisOuverture;


use App\Repository\DesignationConstructionRepository;
use App\Service\DateService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\EtapeServiceAO;

use App\Entity\ResponsableDemande;

class ModelTypeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    // Constructor injection of the EntityManager and Logger
    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }
#[Route('/AvisOuverture/Description/typeDeDemande', name: 'Affichage_typeDeDemandeAO')]
    public function typeDeDemande(Request $request, SessionInterface $session, EtapeServiceAO $etapesServiceAO,  EntityManagerInterface $entityManager): Response
    {
        $description = new DescriptionTypeDeDemande();

        try {
            // Récupérer les données via EntityManager
            $designations = $entityManager->getRepository(DesignationTypeModel::class)->findAll();
            $form = $this->createForm(DescriptionTypeDeDemandeType::class, $description);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $action = $request->get('action'); // Récupérer le bouton cliqué

                if ($action === 'back') {
                    // Supprimer les données de session pour cette étape
                    $session->remove('etape13');

                    // Rediriger vers l'étape précédente
                    return $this->redirectToRoute('affichage_CateorieClassement');
                }

                // Si le bouton "Suivant" est cliqué, valider le formulaire
                if ($action === 'next' &&  $form->isValid()) {
                    $user = $this->getUser();
                    $description->setUser($user);



                    $dataDescription = $form->getData();
                    // Stocker les données dans la session
                    $session->set('etape1', $dataDescription);
                    return $this->redirectToRoute('enregistrement_mes_donnees');
                }
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

        return $this->render('AvisOuverture/DescriptionTypeDeDemande.html.twig', [
            'designations' => $designations,
            'form' => $form->createView(),
            'etapes' => $etapesServiceAO->getEtapes(),
            'etape_courante' => 1,
        ]);
    }
}