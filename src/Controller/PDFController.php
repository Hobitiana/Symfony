<?php

namespace App\Controller;

use App\Entity\ActiviteCamping;
use App\Entity\ActiviteHotel;
use App\Entity\ActiviteRestaurant;
use App\Entity\GroupeActivite;
use App\Entity\RenseignementCIN;
use App\Entity\RenseignementEntreprise;
use App\Entity\RenseignementIndividuelle;
use App\Entity\RenseignementResponsable;
use App\Entity\RenseignementTypeEntreprise;
use App\Entity\RenseignementVisa;
use App\Entity\User;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PDFController extends AbstractController
{
    private PdfService $pdfService;
    private EntityManagerInterface $entityManager;

    public function __construct(PdfService $pdfService, EntityManagerInterface $entityManager)
    {
        $this->pdfService = $pdfService;
        $this->entityManager = $entityManager;
    }

    #[Route('/generate-pdf/', name: 'generate_pdf')]
    public function generatePdf(): Response
    {
       // Récupérer l'utilisateur connecté
       $user = $this->getUser();

       // Vérifier si l'utilisateur est connecté
       if (!$user) {
           throw $this->createAccessDeniedException('Utilisateur non connecté.');
       }

       // Vérifier si l'utilisateur est une instance de la classe User
       if (!$user instanceof User) {
           throw $this->createAccessDeniedException('Utilisateur non valide.');
       }

       // Obtenir l'identifiant de l'utilisateur
       $userId = $user->getId();

       // Utiliser l'identifiant pour récupérer d'autres données
       $userData = $this->entityManager->getRepository(User::class)->find($userId);

        // Récupérer d'autres données en fonction de l'utilisateur, par exemple :
        $typeEntrepriseRepo = $this->entityManager->getRepository(RenseignementTypeEntreprise::class);
        $responsableRepo = $this->entityManager->getRepository(RenseignementResponsable::class);
        $individuelleRepo = $this->entityManager->getRepository(RenseignementIndividuelle::class);
        $entrepriseRepo = $this->entityManager->getRepository(RenseignementEntreprise::class);
        $cinRepo = $this->entityManager->getRepository(RenseignementCIN::class);
        $visaRepo = $this->entityManager->getRepository(RenseignementVisa::class);

        $typeEntreprise = $typeEntrepriseRepo->findBy(['user' => $user]);
        $responsable = $responsableRepo->findBy(['user' => $user]);
        $individuelle = $individuelleRepo->findBy(['user' => $user]);
        $entreprise = $entrepriseRepo->findBy(['user' => $user]);
        $cin = $cinRepo->findBy(['user' => $user]);
        $visa = $visaRepo->findBy(['user' => $user]);

        // Génération du contenu HTML à partir des données récupérées
        $htmlContent = $this->renderView('AvisPrealable/pdf_template.html.twig', [
            'user' => $user,
            'typeEntreprise' => $typeEntreprise,
            'responsable' => $responsable,
            'individuelle' => $individuelle,
            'entreprise' => $entreprise,
            'cin' => $cin,
            'visa' => $visa,
        ]);

        // Génération du PDF
        $this->pdfService->generatePdf($htmlContent, 'document_'.$userId.'.pdf');

        return new Response(); // Cette ligne sera remplacée par le PDF stream
    }
}
