<?php

namespace App\Controller;

use App\Entity\ActiviteCamping;
use App\Entity\Activite1;
use App\Entity\GroupeActivite;
use App\Entity\GroupeActivite1;
use App\Entity\CasDeLocation;
use App\Entity\CategorieClassement;
use App\Entity\CommentaireDocument;
use App\Entity\Environnement;
use App\Entity\LieuImplantation;
use App\Entity\NatureOuvrage;
use App\Entity\NatureProjet;
use App\Entity\PlanMasse;
use App\Entity\RenseignementCIN;
use App\Entity\RenseignementEntreprise;
use App\Entity\RenseignementIndividuelle;
use App\Entity\RenseignementResponsable;
use App\Entity\RenseignementTypeEntreprise;
use App\Entity\RenseignementVisa;
use App\Entity\RelationActivite;
use App\Entity\TypeActivite;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Entity\TypeEtablissement;
use App\Entity\User;
use App\Form\UploadPdfType;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

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

//Infrastructure
        $GroupeActiviteRepo = $this->entityManager->getRepository(RelationActivite::class);

        $RenseignementEntrepriseRepo = $this->entityManager->getRepository(RenseignementEntreprise::class);
        $RenseignementResponsableRepo = $this->entityManager->getRepository(RenseignementResponsable::class);
        $RenseignementIndividuelleRepo = $this->entityManager->getRepository(RenseignementIndividuelle::class);
        $RenseignementCinRepo = $this->entityManager->getRepository(RenseignementCIN::class);
        $RenseignementVisaRepo = $this->entityManager->getRepository(RenseignementVisa::class);

        $natureProjetRepo = $this->entityManager->getRepository(NatureProjet::class);
        $TypeEtablissementRepo = $this->entityManager->getRepository(TypeEtablissement::class);
       
        $LieuImplantationRepo = $this->entityManager->getRepository(LieuImplantation::class);
        $EnvironnementRepo = $this->entityManager->getRepository(Environnement::class);
        $TypeConstructionRepo = $this->entityManager->getRepository(TypeConstruction::class);
        $TypeConstructionDetailRepo = $this->entityManager->getRepository(TypeConstructionDetail::class);
        $NatureOuvrageRepo = $this->entityManager->getRepository(NatureOuvrage::class);
        $PlanMasseRepo = $this->entityManager->getRepository(PlanMasse::class);
        $CasDeLocationRepo = $this->entityManager->getRepository(CasDeLocation::class);
        $CategorieClassementRepo = $this->entityManager->getRepository(CategorieClassement::class);
        //Etablissement

        $GroupeActivite = $GroupeActiviteRepo->findBy(['user' => $user]);

     
        $RenseignementResponsable = $RenseignementResponsableRepo->findBy(['user' => $user]);
        $RenseignementIndividuelle = $RenseignementIndividuelleRepo->findBy(['user' => $user]);
        $RenseignementEntreprise = $RenseignementEntrepriseRepo->findBy(['user' => $user]);
        $RenseignementCin = $RenseignementCinRepo->findBy(['user' => $user]);
        $RenseignementVisa = $RenseignementVisaRepo->findBy(['user' => $user]);


        $natureProjet=  $natureProjetRepo ->findBy(['user' => $user]);
        $TypeEtablissement    = $TypeEtablissementRepo ->findBy(['user' => $user]);
        $GroupeActivite   =   $GroupeActiviteRepo ->findBy(['user' => $user]);
        $LieuImplantation  =   $LieuImplantationRepo ->findBy(['user' => $user]);
        $Environnement    =   $EnvironnementRepo ->findBy(['user' => $user]);
        $TypeConstruction =   $TypeConstructionRepo ->findBy(['user' => $user]);
       
        $typeEntreprise =$typeEntrepriseRepo->findBy(['user' => $user]);


        $typeConstructions = $this->entityManager->getRepository(TypeConstruction::class)->findByUser($user);


        // Récupérer les détails des constructions
        $typeConstructionDetails = [];
        foreach ($typeConstructions as $typeConstruction) {
            $details = $typeConstruction->getDetails();
            foreach ($details as $detail) {
                $typeConstructionDetails[] = $detail;
            }
        }

        $NatureOuvrage =   $NatureOuvrageRepo ->findBy(['user' => $user]);
        $PlanMasse =   $PlanMasseRepo ->findBy(['user' => $user]);
        $CasDeLocation  =   $CasDeLocationRepo ->findBy(['user' => $user]);
        $CategorieClassement  =   $CategorieClassementRepo ->findBy(['user' => $user]);

        foreach ($PlanMasse as $item) {
            $item->planMasseBase64 = base64_encode(stream_get_contents($item->getPlanMasse()));
            $item->planEsquisseBase64 = base64_encode(stream_get_contents($item->getPlanEsquisse()));
            $item->planImmatriculationBase64 = base64_encode(stream_get_contents($item->getPlanImmatriculation()));
            $item->planAssainissementBase64 = base64_encode(stream_get_contents($item->getPlanAssainissement()));
            $item->certificatSituationJuridiqueTerrainBase64 = base64_encode(stream_get_contents($item->getCertificatSituationJuridiqueTerrain()));
        }
        foreach ($CasDeLocation as $item) {
            if ($item->getDateDebut() instanceof \DateTimeInterface) {
                $item->dateDebutFormatted = $item->getDateDebut()->format('d/m/Y');
            }

            if ($item->getDateFin() instanceof \DateTimeInterface) {
                $item->dateFinFormatted = $item->getDateFin()->format('d/m/Y');
            }
        }
        // Génération du contenu HTML à partir des données récupérées
        $htmlContent = $this->renderView('AvisPrealable/pdf_template.html.twig', [
            'user' => $user,
            'typeEntreprise' => $typeEntreprise,
            'RenseignementResponsable' => $RenseignementResponsable,
            'RenseignementIndividuelle' => $RenseignementIndividuelle,
            'RenseignementEntreprise' => $RenseignementEntreprise,
            'RenseignementCin' => $RenseignementCin,
            'RenseignementVisa' => $RenseignementVisa,
            'natureProjet' => $natureProjet,
            'TypeEtablissement' => $TypeEtablissement,
            'GroupeActivite' => $GroupeActivite,
            'LieuImplantation' => $LieuImplantation,
            'Environnement' => $Environnement,
            'TypeConstruction' => $typeConstructionDetails,
            'NatureOuvrage' => $NatureOuvrage,
            'PlanMasse' => $PlanMasse,
            'CasDeLocation' => $CasDeLocation,
            'CategorieClassement' => $CategorieClassement,
        ]);

        // Génération du PDF
        $this->pdfService->generatePdf($htmlContent, 'document_'.$userId.'.pdf');

        return new Response(); // Cette ligne sera remplacée par le PDF stream
    }

    //ENVOYE PDF
    #[Route('/upload-pdf', name: 'app_upload_pdf')]
    public function uploadPdf(HttpFoundationRequest $request, MailerInterface $mailer, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UploadPdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfFile = $form->get('pdfFile')->getData();

            if ($pdfFile) {
                $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdfFile->guessExtension();

                try {
                    $pdfFile->move(
                        $this->getParameter('pdf_directory'), // Make sure to configure this parameter
                        $newFilename
                    );

                    $transport = new EsmtpTransport('smtp.gmail.com', 465, 'ssl');
                    $transport->setUsername('hobitianaandriamanantena@gmail.com');
                    $transport->setPassword('dqqc wzmh kivm john');

            $mailer = new Mailer($transport);




                    // Send the email with the PDF attachment
                    $email = (new Email())
                        ->from('hobitianaandriamanantena@gmail.com')
                        ->to('mioratianalinah17@gmail.com') //olona handefasana ministere
                        ->subject('PDF Submission')
                        ->text('Voici ma demande.')
                        ->attachFromPath($this->getParameter('pdf_directory').'/'.$newFilename);

                    $mailer->send($email);

                    $this->addFlash('success', 'PDF uploaded and sent successfully!');

                    return $this->redirectToRoute('app_upload_pdf');
                } catch (FileException $e) {
                    $this->addFlash('danger', 'There was an error uploading the file.');
                }
            }
        }

        return $this->render('pdf/upload.html.twig', [
            'uploadPdfForm' => $form->createView(),
        ]);
    }

    #[Route('/user/view-pdf', name: 'view_user_pdf')]
    public function generateMaDemande(): Response
    {
       // Récupérer l'utilisateur connecté
       $user = $this->getUser();
       $userId = $user->getId();

      


       // Obtenir l'identifiant de l'utilisateur
      // Utiliser l'identifiant pour récupérer d'autres données
      $userData = $this->entityManager->getRepository(User::class)->find($userId);

      // Récupérer d'autres données en fonction de l'utilisateur, par exemple :
      $typeEntrepriseRepo = $this->entityManager->getRepository(RenseignementTypeEntreprise::class);

//Infrastructure
      $GroupeActiviteRepo = $this->entityManager->getRepository(RelationActivite::class);

      $RenseignementEntrepriseRepo = $this->entityManager->getRepository(RenseignementEntreprise::class);
      $RenseignementResponsableRepo = $this->entityManager->getRepository(RenseignementResponsable::class);
      $RenseignementIndividuelleRepo = $this->entityManager->getRepository(RenseignementIndividuelle::class);
      $RenseignementCinRepo = $this->entityManager->getRepository(RenseignementCIN::class);
      $RenseignementVisaRepo = $this->entityManager->getRepository(RenseignementVisa::class);

      $natureProjetRepo = $this->entityManager->getRepository(NatureProjet::class);
      $TypeEtablissementRepo = $this->entityManager->getRepository(TypeEtablissement::class);
     
      $LieuImplantationRepo = $this->entityManager->getRepository(LieuImplantation::class);
      $EnvironnementRepo = $this->entityManager->getRepository(Environnement::class);
      $TypeConstructionRepo = $this->entityManager->getRepository(TypeConstruction::class);
      $TypeConstructionDetailRepo = $this->entityManager->getRepository(TypeConstructionDetail::class);
      $NatureOuvrageRepo = $this->entityManager->getRepository(NatureOuvrage::class);
      $PlanMasseRepo = $this->entityManager->getRepository(PlanMasse::class);
      $CasDeLocationRepo = $this->entityManager->getRepository(CasDeLocation::class);
      $CategorieClassementRepo = $this->entityManager->getRepository(CategorieClassement::class);
      //Etablissement

      $GroupeActivite = $GroupeActiviteRepo->findBy(['user' => $user]);

   
      $RenseignementResponsable = $RenseignementResponsableRepo->findBy(['user' => $user]);
      $RenseignementIndividuelle = $RenseignementIndividuelleRepo->findBy(['user' => $user]);
      $RenseignementEntreprise = $RenseignementEntrepriseRepo->findBy(['user' => $user]);
      $RenseignementCin = $RenseignementCinRepo->findBy(['user' => $user]);
      $RenseignementVisa = $RenseignementVisaRepo->findBy(['user' => $user]);


      $natureProjet=  $natureProjetRepo ->findBy(['user' => $user]);
      $TypeEtablissement    = $TypeEtablissementRepo ->findBy(['user' => $user]);
      $GroupeActivite   =   $GroupeActiviteRepo ->findBy(['user' => $user]);
      $LieuImplantation  =   $LieuImplantationRepo ->findBy(['user' => $user]);
      $Environnement    =   $EnvironnementRepo ->findBy(['user' => $user]);
      $TypeConstruction =   $TypeConstructionRepo ->findBy(['user' => $user]);
     
      $typeEntreprise =$typeEntrepriseRepo->findBy(['user' => $user]);


      $typeConstructions = $this->entityManager->getRepository(TypeConstruction::class)->findByUser($user);


        // Récupérer les détails des constructions
        $typeConstructionDetails = [];
        foreach ($typeConstructions as $typeConstruction) {
            $details = $typeConstruction->getDetails();
            foreach ($details as $detail) {
                $typeConstructionDetails[] = $detail;
            }
        }

        $NatureOuvrage =   $NatureOuvrageRepo ->findBy(['user' => $userData ]);
        $PlanMasse =   $PlanMasseRepo ->findBy(['user' => $userData ]);
        $CasDeLocation  =   $CasDeLocationRepo ->findBy(['user' => $userData ]);
        $CategorieClassement  =   $CategorieClassementRepo ->findBy(['user' => $user]);

        foreach ($PlanMasse as $item) {
            $item->planMasseBase64 = base64_encode(stream_get_contents($item->getPlanMasse()));
            $item->planEsquisseBase64 = base64_encode(stream_get_contents($item->getPlanEsquisse()));
            $item->planImmatriculationBase64 = base64_encode(stream_get_contents($item->getPlanImmatriculation()));
            $item->planAssainissementBase64 = base64_encode(stream_get_contents($item->getPlanAssainissement()));
            $item->certificatSituationJuridiqueTerrainBase64 = base64_encode(stream_get_contents($item->getCertificatSituationJuridiqueTerrain()));
        }
        foreach ($CasDeLocation as $item) {
            if ($item->getDateDebut() instanceof \DateTimeInterface) {
                $item->dateDebutFormatted = $item->getDateDebut()->format('d/m/Y');
            }

            if ($item->getDateFin() instanceof \DateTimeInterface) {
                $item->dateFinFormatted = $item->getDateFin()->format('d/m/Y');
            }
        }
        // Génération du contenu HTML à partir des données récupérées
       return $this->render('admin/maDemande.html.twig', [
        'user' => $user,
        'typeEntreprise' => $typeEntreprise,
        'RenseignementResponsable' => $RenseignementResponsable,
        'RenseignementIndividuelle' => $RenseignementIndividuelle,
        'RenseignementEntreprise' => $RenseignementEntreprise,
        'RenseignementCin' => $RenseignementCin,
        'RenseignementVisa' => $RenseignementVisa,
        'natureProjet' => $natureProjet,
        'TypeEtablissement' => $TypeEtablissement,
        'GroupeActivite' => $GroupeActivite,
        'LieuImplantation' => $LieuImplantation,
        'Environnement' => $Environnement,
        'TypeConstruction' => $typeConstructionDetails,
        'NatureOuvrage' => $NatureOuvrage,
        'PlanMasse' => $PlanMasse,
        'CasDeLocation' => $CasDeLocation,
        'CategorieClassement' => $CategorieClassement,
        ]);

       
    }
    #[Route('/user/{id}/traiter-document', name: 'traiter_document')]
public function traiterDocument(HttpFoundationRequest $request, User $user, EntityManagerInterface $entityManager): Response
{
    // Récupérer le document non traité
    $document = $user->getDocuments()->filter(function ($document) {
        return !$document->isProcessed();
    })->first();

    if (!$document) {
        throw $this->createNotFoundException('Aucun document non traité trouvé pour cet utilisateur.');
    }

    // Récupérer le commentaire du formulaire
    $commentaire = $request->get('commentaire');

    // Vérifier si l'utilisateur a cliqué sur "Valider" ou "Rejeter"
    if ($request->isMethod('POST')) {
        // Créer une nouvelle entité Commentaire
        $comment = new CommentaireDocument();
        $comment->setUser($user);
        $comment->setCommentaire($commentaire);
        $comment->setDate(new \DateTime());

        if ($request->request->has('valider')) {
            $comment->setStatus('validé');
        } elseif ($request->request->has('rejeter')) {
            $comment->setStatus('refusé');
        }
        // Sauvegarder le commentaire dans la base de données
        $entityManager->persist($comment);

        // Mettre à jour l'entité Document pour marquer le document comme traité et changer son statut
        $document->setProcessed(true);
        
       

        // Sauvegarder les modifications dans la base de données
        $entityManager->persist($document);
        $entityManager->flush();

        // Rediriger vers une autre page après traitement
        return $this->redirectToRoute('view_user_pdf');
    }

    return $this->render('document/traiter.html.twig', [
        'user' => $user,
        'document' => $document,
    ]);
}
}
