<?php

namespace App\Controller;

use App\Entity\CasDeLocation;
use App\Entity\CategorieClassement;
use App\Entity\LieuImplantation;
use App\Form\CasDeLocationType;
use App\Form\CategorieClassementType;
use App\Form\LieuImplantationType;
use App\Repository\DesignationConstructionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CasDeLocationController extends AbstractController
{
    #[Route('/AvisPrealable/CasDeLocation/', name: 'affichage_CasDeLocation')]
    public function index(HttpFoundationRequest $request, SessionInterface $session, EtapeService $etapesService, EntityManagerInterface $entityManager, DesignationConstructionRepository $designationRepo): Response
    {
        $casDeLocation = new CasDeLocation();

        $form = $this->createForm(CasDeLocationType::class, $casDeLocation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape10');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_UploadFichier');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $casDeLocation->setUser($user);
                //$entityManager->persist($casDeLocation);
                // $entityManager->flush();
                $dataCasDeLocation = $form->getData();
                // Stocker les données dans la session
                $session->set('etape11', $dataCasDeLocation);

                return $this->redirectToRoute('affichage_CategorieClassement'); // Adjust the redirect route as needed
            }
        }
        return $this->render('AvisPrealable/CasDeLocation.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 11,
        ]);
    }
}
