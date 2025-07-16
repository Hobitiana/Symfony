<?php

namespace App\Controller\AvisOuverture;

use App\Entity\ActiviteCamping;
use App\Entity\ActiviteHotel;
use App\Entity\ActiviteRestaurant;
use App\Entity\CasDeLocation;
use App\Entity\CategorieClassement;
use App\Entity\Environnement;
use App\Entity\GroupeActivite;
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
use App\Entity\ResultatDemande;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Entity\TypeEtablissement;
use App\Entity\UploadAvisOuverture;
use App\Entity\User;
use App\Form\EntreReferenceAvisOuvertureType;
use App\Form\InputAvisOuvertureType;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\EtapeServiceAO;
use App\Entity\DescriptionTypeDeDemande;
use App\Entity\DesignationTypeModel;
use App\Form\DescriptionTypeDeDemandeType;
use App\Entity\DossierAO;


class OuvertureController extends AbstractController
{
   
    private EntityManagerInterface $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {
     
        $this->entityManager = $entityManager;
    }
    #[Route('/Demande/AvisOuverutre', name: 'accueil_AvisOuverture')]
    public function index(): Response
    {
        return $this->render('AvisOuverture/Accueil.html.twig', [
            
        ]);
    }
    #[Route('/Demande/verification/AvisOuverutre', name: 'accueil_VerificationDemande')]
    public function new(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $resultDemande = new ResultatDemande();
        $ResultatDemandeRepo = $this->entityManager->getRepository(ResultatDemande::class);

        $form = $this->createForm(EntreReferenceAvisOuvertureType::class, $resultDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $resultDemande->setUser($user);
            $reference = $form->get('reference')->getData();
            $userEtSaDemande = $ResultatDemandeRepo->findBy(['user' => $user, 'reference' => $reference]);

        if (!empty($userEtSaDemande)) {
            // Si la demande existe déjà, rediriger vers une autre page
            return $this->redirectToRoute('accueil_NewDemande');
        }

        // Si la demande n'existe pas, rediriger vers la même page ou une autre page
        return $this->redirectToRoute('accueil_VerificationDemande');
    }
        return $this->render('AvisOuverture/EntreVotreReference.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/AutorisationOuverture/Description/typeDeDemande', name: 'Affichage_typeDeDemandeAO')]
    public function typeDeDemande(HttpFoundationRequest $request, SessionInterface $session, EtapeServiceAO $etapesService,  EntityManagerInterface $entityManager): Response
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
                    $session->remove('etape1');

                    // Rediriger vers l'étape précédente
                    return $this->redirectToRoute('affichage_UploadFichierAO');
                }

                // Si le bouton "Suivant" est cliqué, valider le formulaire
                if ($action === 'next' &&  $form->isValid()) {
                    $user = $this->getUser();
                    $description->setUser($user);



                    $dataDescription = $form->getData();
                    // Stocker les données dans la session
                    $session->set('etape2', $dataDescription);
                    return $this->redirectToRoute('enregistrement_mes_donnees');
                }
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

        return $this->render('AvisOuverture/DescriptionTypeDeDemande.html.twig', [
            'designations' => $designations,
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 2,
        ]);
    }

    #[Route('/Demande/AvisOuverutre', name: 'enregistrerAO')]
    public function enregistrerAO(): Response
    {
        $action = $request->get('action');
        if ($action === 'cancel') {
            // Effacer les données de session et rediriger

            $session->remove('etape1');
            $session->remove('etape2');



            return $this->redirectToRoute('affichage_NatureDeDeamnde'); // Remplacez 'accueil' par la route souhaitée
        }
        $session = $requestStack->getSession();
        if ($action === 'save') {
            try {
                $user = $this->getUser();
                // Etape 1
                $dataEtape1 = $session->get('etape1');
               
                if (is_object($dataEtape1)) {
                    $dataEtape1 = [
                        'lettreDemande' => $dataEtape1->getLettreDemande(),
                        'cnaps' => $dataEtape1->getCnaps(),
                        'copieVisaCertifie' => $dataEtape1->getCopieVisaCertifie(),
                        'attestationAssurance' => $dataEtape1->getAttestationAssurance(),
                        'attestationFinanciere' => $dataEtape1->getAttestationFinanciere()
                    ];
                }
                
                $planMasse = new DossierAO();
                $planMasse->setLettreDemande($dataEtape10['lettreDemande'] ?? null);
                $planMasse->setCnaps($dataEtape10['cnaps'] ?? null);
                $planMasse->setCopieVisaCertifie($dataEtape10['copieVisaCertifie'] ?? null);
                $planMasse->setAttestationAssurance($dataEtape10['attestationAssurance'] ?? null);
                $planMasse->setAttestationFinanciere($dataEtape10['attestationFinanciere'] ?? null);
                
                // Associer à l'utilisateur si nécessaire
                $planMasse->setUser($user); // $user doit être l'entité User courante
                
                // Persist et flush dans le gestionnaire d’entité
                $entityManager->persist($planMasse);
                $entityManager->flush();
                
                // Etape 2
                $dataEtape2 = $session->get('etape2');


//enregis
                $maTypeDeDemande = "Autorisation Ouverture";
                $maDemande->setMaTypeDeDemande($maTypeDeDemande);
                $status = "En Attente";
                $maDemande->setStatus($status);

                $dateMada = $DateService->getDateTimeMadagascar();
                $maDemande->setDateActuel($dateMada);
            } catch (Exception $e) {
                // Si l'utilisateur n'est pas connecté, rediriger vers la page d'accueil
                return $this->redirectToRoute('accueil');
            }
        }
        return $this->render('AvisOuverture/Accueil.html.twig', [
            
        ]);
    }

    #[Route('/Demande/New/AvisOuverutre', name: 'accueil_NewDemande')]
    public function nouvelleDemande(): Response
    {

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
         $GroupeActiviteRepo = $this->entityManager->getRepository(GroupeActivite::class);
         $TypeActiviteHotelRepo = $this->entityManager->getRepository(ActiviteHotel::class);
         $TypeActiviteCampingRepo = $this->entityManager->getRepository(ActiviteCamping::class);
         $TypeActiviteRestaurantRepo = $this->entityManager->getRepository(ActiviteRestaurant::class);
 
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
 
         $typeEntreprise = $typeEntrepriseRepo->findBy(['user' => $user]);
         $RenseignementResponsable = $RenseignementResponsableRepo->findBy(['user' => $user]);
         $RenseignementIndividuelle = $RenseignementIndividuelleRepo->findBy(['user' => $user]);
         $RenseignementEntreprise = $RenseignementEntrepriseRepo->findBy(['user' => $user]);
         $RenseignementCin = $RenseignementCinRepo->findBy(['user' => $user]);
         $RenseignementVisa = $RenseignementVisaRepo->findBy(['user' => $user]);
 
 
         $natureProjet=  $natureProjetRepo ->findBy(['user' => $user]);
         $TypeEtablissement    = $TypeEtablissementRepo ->findBy(['user' => $user]);
         $TypeActiviteHot   =  $TypeActiviteHotelRepo ->findBy(['user' => $user]);
         $TypeActiviteCamp   =  $TypeActiviteCampingRepo ->findBy(['user' => $user]);
         $TypeActiviteResto   =  $TypeActiviteRestaurantRepo ->findBy(['user' => $user]);
         $GroupeActivite   =   $GroupeActiviteRepo ->findBy(['user' => $user]);
         $LieuImplantation  =   $LieuImplantationRepo ->findBy(['user' => $user]);
         $Environnement    =   $EnvironnementRepo ->findBy(['user' => $user]);
         $TypeConstruction =   $TypeConstructionRepo ->findBy(['user' => $user]);
        
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
         return $this->render('AvisOuverture/NewDemande.html.twig', [
             'user' => $user,
             'typeEntreprise' => $typeEntreprise,
             'RenseignementResponsable' => $RenseignementResponsable,
             'RenseignementIndividuelle' => $RenseignementIndividuelle,
             'RenseignementEntreprise' => $RenseignementEntreprise,
             'RenseignementCin' => $RenseignementCin,
             'RenseignementVisa' => $RenseignementVisa,
             'natureProjet' => $natureProjet,
             'TypeEtablissement' => $TypeEtablissement,
             'TypeActiviteHotel' => $TypeActiviteHot,
             'TypeActiviteCamp' => $TypeActiviteCamp,
             'TypeActiviteResto' => $TypeActiviteResto,
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
    #[Route('/Demande/Upload/AvisOuverture/', name: 'affichage_UploadAvisOuverture')]
    public function uploadAvisOuverture(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $uploadAvisOuverture = new UploadAvisOuverture();
    $form = $this->createForm(InputAvisOuvertureType::class, $uploadAvisOuverture);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $judiciaireFile */
        $judiciaireFile = $form->get('judiciaire')->getData();
        if ($judiciaireFile) {
            // Lire le contenu du fichier et le stocker dans la propriété
            $uploadAvisOuverture->setJudiciaire(file_get_contents($judiciaireFile->getPathname()));
        }

        /** @var UploadedFile $cinFile */
        $cinFile = $form->get('CIN')->getData();
        if ($cinFile) {
            $uploadAvisOuverture->setCin(file_get_contents($cinFile->getPathname()));
        }

        /** @var UploadedFile $visaFile */
        $visaFile = $form->get('visa')->getData();
        if ($visaFile) {
            $uploadAvisOuverture->setVisa(file_get_contents($visaFile->getPathname()));
        }

        /** @var UploadedFile $statutsFile */
        $statutsFile = $form->get('statuts')->getData();
        if ($statutsFile) {
            $uploadAvisOuverture->setStatuts(file_get_contents($statutsFile->getPathname()));
        }

        /** @var UploadedFile $assuranceFile */
        $assuranceFile = $form->get('assurance')->getData();
        if ($assuranceFile) {
            $uploadAvisOuverture->setAssurance(file_get_contents($assuranceFile->getPathname()));
        }

        /** @var UploadedFile $financiereFile */
        $financiereFile = $form->get('financiere')->getData();
        if ($financiereFile) {
            $uploadAvisOuverture->setFinanciere(file_get_contents($financiereFile->getPathname()));
        }

        /** @var UploadedFile $certificatJuridiqueFile */
        $certificatJuridiqueFile = $form->get('certificatJuridique')->getData();
        if ($certificatJuridiqueFile) {
            $uploadAvisOuverture->setCertificatJuridique(file_get_contents($certificatJuridiqueFile->getPathname()));
        }
        $user = $this->getUser(); // Récupère l'utilisateur connecté
        $uploadAvisOuverture->setUser($user);
        // Persist and flush the entity
        $entityManager->persist($uploadAvisOuverture);
        $entityManager->flush();

        // Redirection ou autre logique après l'enregistrement
        return $this->redirectToRoute('accueil_AvisOuverture');
    }

        return $this->render('AvisOuverture/UploadAvisOuverture.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}
