<?php

namespace App\Controller;

use App\Repository\MaDemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use app\Entity\MaDemande;

class DemandeController extends AbstractController
{
    private $maDemandeRepository;

    public function __construct(MaDemandeRepository $maDemandeRepository)
    {
        $this->maDemandeRepository = $maDemandeRepository;
    }
    #[Route('/demande', name: 'app_demande')]
    public function index(): Response
    {
        return $this->render('demande/index.html.twig', [
            'controller_name' => 'DemandeController',
        ]);
    }
    #[Route('/liste/demande', name: 'liste_demande')]
    public function listeDemande(HttpFoundationRequest $request): Response
    {
        $user = $this->getUser();
        $maDemande = $this->maDemandeRepository->findBy(['idUsers' => $user]);
    
        $searchQuery = $request->query->get('search', '');
        $sortField = $request->query->get('sort', 'dateActuel'); // Default sort field
        $sortDirection = $request->query->get('direction', 'asc'); // Default sort direction

        if (!$maDemande) {
           // return new Response("Demande non trouvée pour cet utilisateur.", 404);
           return $this->render('demande/liste.html.twig', [
            'demandes' => $maDemande,
            'searchQuery' => $searchQuery,
            'sortDirection' => $sortDirection,
            'searchQuery' => $searchQuery,
            
        ]);
        }
    
        // Handle search
      
    
        // Filter demandes based on search query
        if ($searchQuery) {
            $maDemande = array_filter($maDemande, function ($demande) use ($searchQuery) {
                return stripos($demande->getMaTypeDeDemande(), $searchQuery) !== false ||
                       stripos($demande->getStatus(), $searchQuery) !== false ||
                       ($demande->getIdRelationActivite() && 
                        (stripos($demande->getIdRelationActivite()->getNomGroupe(), $searchQuery) !== false ||
                         stripos($demande->getIdRelationActivite()->getNomActivite(), $searchQuery) !== false));
            });
        }
    
        // Handle sorting
       
    
        // Sort the demandes based on sort field and direction
        usort($maDemande, function ($a, $b) use ($sortField, $sortDirection) {
            $valueA = $a->{'get' . ucfirst($sortField)}();
            $valueB = $b->{'get' . ucfirst($sortField)}();
    
            if ($sortDirection === 'desc') {
                return $valueA <=> $valueB;
            }
            return $valueB <=> $valueA;
        });
    
        // Passer les données à la vue Twig
        return $this->render('demande/liste.html.twig', [
            'demandes' => $maDemande,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchQuery' => $searchQuery,
        ]);
    }

    #[Route('/ma-demande/supprimer/{id}', name: 'app_ma_demande_delete')]
    public function delete(MaDemande $demande, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Suppression de la demande de la base de données
        $entityManager->remove($demande);
        $entityManager->flush();

        // Rediriger vers la liste des demandes ou la page d'accueil après la suppression
        $this->addFlash('success', 'Demande supprimée avec succès!');
        return $this->redirectToRoute('liste_demande'); // Rediriger vers la liste des demandes
    }
    
    
}
