<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\RenseignementEntreprise;
use App\Form\RenseignementEntrepriseType;
use App\Repository\RenseignementEntrepriseRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(HttpFoundationRequest $request, EtapeService $etapesService, SessionInterface $session, EntityManagerInterface $entityManager, RenseignementEntrepriseRepository $renseignementEntrepriseRepository): Response
    {
        $entreprise = new RenseignementEntreprise();


        $form = $this->createForm(RenseignementEntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $entreprise->setUser($user);
            // $entityManager->persist($entreprise);
            //$entityManager->flush();
            $dataEntreprise = $form->getData();
            // Stocker les données dans la session
            $session->set('etape2', $dataEntreprise);
            $nationalite = $entreprise->getNationalite();
            // var_dump($nationalite);
            $nat = $nationalite->getNomNationalite();

            if ($nat == "Malagasy") {
                return $this->redirectToRoute('affichage_RenseignementCollectif');
            }
            return $this->redirectToRoute('affichage_RenseignementCollectifvisa'); // Adjust the redirect route as needed // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/entreprise.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 2,
        ]);
    }
}
