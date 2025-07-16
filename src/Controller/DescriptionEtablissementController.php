<?php

namespace App\Controller;

use App\Entity\Activite1;
use App\Entity\CasDeLocation;
use App\Entity\CategorieClassement;
use App\Entity\DescriptionHebergement;
use App\Entity\DescriptionHebergementDetail;
use App\Entity\DescriptionQuestionChoixHebergement;
use App\Entity\DescriptionQuestionChoixHebergementDetail;
use App\Entity\DescriptionQuestionHebergement;
use App\Entity\DescriptionQuestionHebergementDetail;
use App\Entity\DescriptionTypeDeDemande;
use App\Entity\DesignationHebergement;
use App\Entity\DesignationTypeModel;
use App\Entity\Environnement;
use App\Entity\LieuImplantation;
use App\Entity\MaDemande;
use App\Entity\Nationalite;
use App\Entity\NatureOuvrage;
use App\Entity\NatureProjet;
use App\Entity\PlanMasse;
use App\Entity\QuestionChoixHebergement;
use App\Entity\QuestionHebergement;
use App\Entity\RelationActivite;
use App\Entity\RenseignementCIN;
use App\Entity\RenseignementEntreprise;
use App\Entity\RenseignementIndividuelle;
use App\Entity\RenseignementTypeEntreprise;
use App\Entity\RenseignementVisa;
use App\Entity\TypeConstruction;
use App\Entity\TypeConstructionDetail;
use App\Entity\User;
use App\Form\DescriptionHebergementType;
use App\Form\DescriptionQuestionChoixHebergementType;
use App\Form\DescriptionQuestionHebergementType;
use App\Form\DescriptionTypeDeDemandeType;
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
use App\Service\EtapeService;

use App\Entity\ResponsableDemande;

class DescriptionEtablissementController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    // Constructor injection of the EntityManager and Logger
    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    #[Route('/AvisPrealable/Description/Hebergement', name: 'Affichage_DescriptionHebergement')]
    public function hebergement(Request $request, EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionHebergement();

        try {
            $designations = $this->entityManager->getRepository(DesignationHebergement::class)->findAll();

            foreach ($designations as $designation) {
                $detail = new DescriptionHebergementDetail();
                $detail->setDesignation($designation->getDesignation());
                $description->addDetail($detail);
            }

            $form = $this->createForm(DescriptionHebergementType::class, $description);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $action = $request->get('action'); // Récupérer le bouton cliqué

                if ($action === 'back') {
                    // Supprimer les données de session pour cette étape
                    $session->remove('etape12');

                    // Rediriger vers l'étape précédente
                    return $this->redirectToRoute('affichage_CateorieClassement');
                }

                // Si le bouton "Suivant" est cliqué, valider le formulaire
                if ($action === 'next' &&  $form->isValid()) {
                    $user = $this->getUser();
                    $description->setUser($user);
                    // $this->entityManager->persist($description);
                    // $this->entityManager->flush();
                    $dataDescription = $form->getData();
                    // Stocker les données dans la session
                    $session->set('etape13', $dataDescription);

                    return $this->redirectToRoute('Affichage_QuestionDescriptionHebergement');
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in hebergement: ' . $e->getMessage());
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

        return $this->render('AvisPrealable/DescriptionHebergement.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 13,
        ]);
    }

    #[Route('/AvisPrealable/Description/Question/Hebergement', name: 'Affichage_QuestionDescriptionHebergement')]
    public function questionHebergement(Request $request,  EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionQuestionHebergement();

        try {
            $designations = $this->entityManager->getRepository(QuestionHebergement::class)->findAll();

            foreach ($designations as $designation) {
                $detail = new DescriptionQuestionHebergementDetail();
                $detail->setDesignation($designation->getQuestions());
                $description->addDetail($detail);
            }

            $form = $this->createForm(DescriptionQuestionHebergementType::class, $description);
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
                    // $this->entityManager->persist($description);
                    // $this->entityManager->flush();
                    $dataDescription = $form->getData();
                    // Stocker les données dans la session
                    $session->set('etape14', $dataDescription);
                    return $this->redirectToRoute('Affichage_QuestionChoixDescriptionHebergement');
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in questionHebergement: ' . $e->getMessage());
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

        return $this->render('AvisPrealable/DescriptionQuestionHebergement.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 14,
        ]);
    }

    #[Route('/AvisPrealable/Description/QuestionChoix/Hebergement', name: 'Affichage_QuestionChoixDescriptionHebergement')]
    public function questionChoixHebergement(Request $request,  EtapeService $etapesService, SessionInterface $session): Response
    {
        $description = new DescriptionQuestionChoixHebergement();

        try {
            $designations = $this->entityManager->getRepository(QuestionChoixHebergement::class)->findAll();

            foreach ($designations as $designation) {
                $detail = new DescriptionQuestionChoixHebergementDetail();
                $detail->setDesignation($designation->getQuestions());
                $description->addDetail($detail);
            }

            $form = $this->createForm(DescriptionQuestionChoixHebergementType::class, $description);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $action = $request->get('action'); // Récupérer le bouton cliqué

                if ($action === 'back') {
                    // Supprimer les données de session pour cette étape
                    $session->remove('etape14');

                    // Rediriger vers l'étape précédente
                    return $this->redirectToRoute('affichage_CateorieClassement');
                }

                // Si le bouton "Suivant" est cliqué, valider le formulaire
                if ($action === 'next' &&  $form->isValid()) {
                    $user = $this->getUser();
                    $description->setUser($user);
                    // $this->entityManager->persist($description);
                    // $this->entityManager->flush();
                    $dataDescription = $form->getData();
                    // Stocker les données dans la session
                    $session->set('etape15', $dataDescription);
                    return $this->redirectToRoute('Affichage_typeDeDemande');
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Error in questionChoixHebergement: ' . $e->getMessage());
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

        return $this->render('AvisPrealable/DescriptionQuestionChoixHebergement.html.twig', [
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 15,
        ]);
    }

    #[Route('/AvisPrealable/Description/typeDeDemande', name: 'Affichage_typeDeDemande')]
    public function typeDeDemande(Request $request, SessionInterface $session, EtapeService $etapesService,  EntityManagerInterface $entityManager): Response
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
                    $session->set('etape16', $dataDescription);
                    return $this->redirectToRoute('enregistrement_mes_donnees');
                }
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'An error occurred while processing your request.');
        }

        return $this->render('AvisPrealable/DescriptionTypeDeDemande.html.twig', [
            'designations' => $designations,
            'form' => $form->createView(),
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 16,
        ]);
    }
    #[Route('/AvisPrealable/Enregistrement', name: 'enregistrement_mes_donnees')]
    public function enregistrement(Request $request, RequestStack $requestStack, SessionInterface $session, DateService $DateService, EtapeService $etapesService,  EntityManagerInterface $entityManager): Response
    {


        $action = $request->get('action');
        if ($action === 'cancel') {
            // Effacer les données de session et rediriger

            $session->remove('etape1');
            $session->remove('etape2');
            $session->remove('etape3CIN');
            $session->remove('etape3Visa');
            $session->remove('etape4');
            $session->remove('etape5');
            $session->remove('etape6');
            $session->remove('etape7');
            $session->remove('etape8');
            $session->remove('etape9');
            $session->remove('etape10');
            $session->remove('etape11');
            $session->remove('etape12');


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
                        'typeEntreprise' => $dataEtape1->getTypeEntrprise()
                    ];
                }

                $renseignementTypeEntreprise = new RenseignementTypeEntreprise();
                $renseignementTypeEntreprise->setTypeEntrprise($dataEtape1['typeEntreprise']);
                $renseignementTypeEntreprise->setUser($user);
                // dd($renseignementTypeEntreprise);
                $entityManager->persist($renseignementTypeEntreprise);
                $entityManager->flush();

                // Etape 2
                $dataEtape2 = $session->get('etape2');


                // Si l'objet est récupéré sous forme d'entité, on extrait les données dans un tableau
                if (is_object($dataEtape2)) {
                    if ($dataEtape2 instanceof RenseignementIndividuelle) {
                        $dataEtape2 = [
                            'individuNom' => $dataEtape2->getIndividuNom(),
                            'individuPrenom' => $dataEtape2->getIndividuPrenom(),
                            'adresseIndividu' => $dataEtape2->getAdresseIndividu(),
                            'mailIndividu' => $dataEtape2->getMailIndividu(),
                            'phoneIndividu' => $dataEtape2->getPhoneIndividu(),
                            'nationaliteId' => $dataEtape2->getNationalite() ? $dataEtape2->getNationalite()->getId() : null
                        ];
                    } elseif ($dataEtape2 instanceof RenseignementEntreprise) {
                        $dataEtape2 = [
                            'denominationSociale' => $dataEtape2->getDenominationSociale(),
                            'enseigneCommerciale' => $dataEtape2->getEnseigneCommerciale(),
                            'adresseEntreprise' => $dataEtape2->getAdresseEntreprise(),
                            'registreCommerce' => $dataEtape2->getRegistreCommerce(),
                            'telephoneEntreprise' => $dataEtape2->getTelephoneEntreprise(),
                            'mailEntreprise' => $dataEtape2->getMailEntreprise(),
                            'nomMandataire' => $dataEtape2->getNomMandataire(),
                            'prenomMandataire' => $dataEtape2->getPrenomMandataire(),
                            'nationaliteId' => $dataEtape2->getNationalite() ? $dataEtape2->getNationalite()->getId() : null
                        ];
                    }
                }

                // Si `dataEtape2` contient des informations sur un individu
                if (isset($dataEtape2['individuNom'])) {
                    $renseignementIndividuelle = new RenseignementIndividuelle();
                    $renseignementIndividuelle->setIndividuNom($dataEtape2['individuNom']);
                    $renseignementIndividuelle->setIndividuPrenom($dataEtape2['individuPrenom']);
                    $renseignementIndividuelle->setAdresseIndividu($dataEtape2['adresseIndividu']);
                    $renseignementIndividuelle->setMailIndividu($dataEtape2['mailIndividu']);
                    $renseignementIndividuelle->setPhoneIndividu($dataEtape2['phoneIndividu']);
                    $renseignementIndividuelle->setUser($user);

                    $nationalite = $entityManager->getRepository(Nationalite::class)->find($dataEtape2['nationaliteId']);
                    $renseignementIndividuelle->setNationalite($nationalite);

                    $entityManager->persist($renseignementIndividuelle);
                    $entityManager->flush();
                    //     $renseignementEntreprise = new RenseignementEntreprise();
                    $renseignementEntreprise = null;
                } elseif (isset($dataEtape2['denominationSociale'])) {
                    // Si `dataEtape2` contient des informations sur une entreprise
                    $renseignementEntreprise = new RenseignementEntreprise();
                    $renseignementEntreprise->setDenominationSociale($dataEtape2['denominationSociale']);
                    $renseignementEntreprise->setEnseigneCommerciale($dataEtape2['enseigneCommerciale']);
                    $renseignementEntreprise->setAdresseEntreprise($dataEtape2['adresseEntreprise']);
                    $renseignementEntreprise->setRegistreCommerce($dataEtape2['registreCommerce']);
                    $renseignementEntreprise->setTelephoneEntreprise($dataEtape2['telephoneEntreprise']);
                    $renseignementEntreprise->setMailEntreprise($dataEtape2['mailEntreprise']);
                    $renseignementEntreprise->setNomMandataire($dataEtape2['nomMandataire']);
                    $renseignementEntreprise->setPrenomMandataire($dataEtape2['prenomMandataire']);
                    $renseignementEntreprise->setUser($user);
                    //dd($renseignementEntreprise);
                    $nationalite = $entityManager->getRepository(Nationalite::class)->find($dataEtape2['nationaliteId']);
                    $renseignementEntreprise->setNationalite($nationalite);

                    $entityManager->persist($renseignementEntreprise);
                    $entityManager->flush();
                    $renseignementEntrepriseId = $renseignementEntreprise?->getId();
                    //   dd($renseignementEntrepriseId);
                    // $renseignementIndividuelle = new RenseignementIndividuelle();
                    $renseignementIndividuelle = null;
                }


                // Etape 3
                $dataEtape3CIN = $session->get('etape3CIN');
                if (is_null($dataEtape3CIN)) {
                    // La session 'etape3' est null
                    // Vous pouvez gérer le cas où les données sont null ici, par exemple :
                    $dataEtape3CIN = [];
                    $renseignementCIN = new RenseignementCIN();
                    // Assignez `null` à chaque propriété si les données sont totalement absentes
                    $renseignementCIN = null;
                    $renseignementCINId = null;
                    // dd($dataEtape3CIN);
                } else {
                    $dataEtape3CIN = [
                        'numCIN' => $dataEtape3CIN->getNumCIN(),
                        'dateCIN' => $dataEtape3CIN->getDateCIN()->format('Y-m-d'),
                        'lieuCIN' => $dataEtape3CIN->getLieuCIN(),
                        'duplicataCIN' => $dataEtape3CIN->getDuplicataCIN(),
                        'lieuDuplicataCIN' => $dataEtape3CIN->getLieuDuplicataCIN(),
                        'profession' => $dataEtape3CIN->getProfession(),
                        'nomPere' => $dataEtape3CIN->getNomPere(),
                        'nomMere' => $dataEtape3CIN->getNomMere()
                    ];
                    $renseignementCIN = new RenseignementCIN();
                    $renseignementCIN->setNumCIN($dataEtape3CIN['numCIN']);
                    $renseignementCIN->setDateCIN(new \DateTime($dataEtape3CIN['dateCIN']));
                    $renseignementCIN->setLieuCIN($dataEtape3CIN['lieuCIN']);
                    $renseignementCIN->setDuplicataCIN($dataEtape3CIN['duplicataCIN']);
                    $renseignementCIN->setLieuDuplicataCIN($dataEtape3CIN['lieuDuplicataCIN']);
                    $renseignementCIN->setProfession($dataEtape3CIN['profession']);
                    $renseignementCIN->setNomPere($dataEtape3CIN['nomPere']);
                    $renseignementCIN->setNomMere($dataEtape3CIN['nomMere']);

                    // dd($renseignementCIN);
                    $renseignementCIN->setUser($user);

                    $entityManager->persist($renseignementCIN);
                    $entityManager->flush();

                    // $renseignementCINId = isset($renseignementCIN) && $renseignementCIN->getId() !== null ? $renseignementCIN->getId() : null;
                    $renseignementCINId =  $renseignementCIN->getId();
                    //dd($renseignementCINId);
                }

                $dataEtape3 = $session->get('etape3Visa');
                //   dd($dataEtape3);
                if (is_null($dataEtape3)) {

                    $dataEtape3 = [];
                    $renseignementVisa = new RenseignementVisa();
                    // Assignez `null` à chaque propriété si les données sont totalement absentes
                    $renseignementVisa = null;
                    $renseignementVisaId = null;
                } else {
                    $dataEtape3 = [
                        'numPasseport' => $dataEtape3->getNumPasseport(),
                        'statut' => $dataEtape3->getStatut(),
                        'nomPasseport' => $dataEtape3->getNomPasseport(),
                        'prenomPasseport' => $dataEtape3->getPrenomPasseport(),
                        'dateNaissance' => $dataEtape3->getDateNaissance()->format('Y-m-d'),
                        'nationalite' => $dataEtape3->getNationalite(),
                        'dateDelivrance' => $dataEtape3->getDateDelivrance()->format('Y-m-d'),
                        'validite' => $dataEtape3->getValidite()->format('Y-m-d'),
                        'categorie' => $dataEtape3->getCategorie()
                    ];
                    $renseignementVisa = new RenseignementVisa();
                    $renseignementVisa->setNumPasseport($dataEtape3['numPasseport']);
                    $renseignementVisa->setStatut($dataEtape3['statut']);
                    $renseignementVisa->setNomPasseport($dataEtape3['nomPasseport']);
                    $renseignementVisa->setPrenomPasseport($dataEtape3['prenomPasseport']);
                    $renseignementVisa->setDateNaissance(new \DateTime($dataEtape3['dateNaissance']));
                    $renseignementVisa->setNationalite($dataEtape3['nationalite']);
                    $renseignementVisa->setDateDelivrance(new \DateTime($dataEtape3['dateDelivrance']));
                    $renseignementVisa->setValidite(new \DateTime($dataEtape3['validite']));
                    $renseignementVisa->setCategorie($dataEtape3['categorie']);

                    $renseignementVisa->setUser($user);
                    //  dd($renseignementVisa);
                    // Enregistrer dans la base de données
                    $entityManager->persist($renseignementVisa);
                    $entityManager->flush();
                    //$renseignementVisaId = isset($renseignementVisa) && $renseignementVisa->getId() !== null ? $renseignementVisa->getId() : null;
                    $renseignementVisaId =  $renseignementVisa->getId();
                }



                //etape 5
                // Etape 4
                $dataEtape4 = $session->get('etape4');
                // dd($dataEtape4);
                if (is_object($dataEtape4)) {
                    $dataEtape4 = [
                        'nature' => $dataEtape4->getNature()
                    ];
                }

                $natureProjet = new NatureProjet();
                $natureProjet->setNature($dataEtape4['nature']);
                $natureProjet->setUser($user);

                $entityManager->persist($natureProjet);
                $entityManager->flush();

                $dataEtape5 = $session->get('etape5');
                // dd($dataEtape5);
                //var_dump($dataEtape5);
                if (is_object($dataEtape5)) {
                    $dataEtape5 = [
                        'nomGroupe' => $dataEtape5->getNomGroupe(),
                        'nomActivite' => $dataEtape5->getNomActivite()
                    ];
                }

                $relationActivite = new RelationActivite();
                $relationActivite->setNomGroupe($dataEtape5['nomGroupe']);
                $relationActivite->setNomActivite($dataEtape5['nomActivite']);
                $relationActivite->setUser($user);

                $entityManager->persist($relationActivite);
                $entityManager->flush();

                // Etape 6
                $dataEtape6 = $session->get('etape6');

                if (is_object($dataEtape6)) {
                    $dataEtape6 = [
                        'adresse' => $dataEtape6->getAdresse(),
                        'commune' => $dataEtape6->getCommune(),
                        'district' => $dataEtape6->getDistrict(),
                        'region' => $dataEtape6->getRegion(),
                        'fokotany' => $dataEtape6->getFokotany()
                    ];
                }

                $lieuImplantation = new LieuImplantation();
                $lieuImplantation->setAdresse($dataEtape6['adresse']);
                $lieuImplantation->setCommune($dataEtape6['commune']);
                $lieuImplantation->setDistrict($dataEtape6['district']);
                $lieuImplantation->setRegion($dataEtape6['region']);
                $lieuImplantation->setFokotany($dataEtape6['fokotany']);
                $lieuImplantation->setUser($user);

                $entityManager->persist($lieuImplantation);
                $entityManager->flush();


                //etape 7
                // Récupérer les données de la session
                $dataEtape7 = $session->get('etape7'); // Récupérer les données de l'étape 7

                if (is_object($dataEtape7)) {
                    $dataEtape7 = [
                        'nomSite' => $dataEtape7->getNomSite(),
                        'distance' => $dataEtape7->getDistance(),
                        'est' => $dataEtape7->getEst(),
                        'observation' => $dataEtape7->getObservation()
                    ];
                }
                // Assurez-vous que les données existent avant de les utiliser
                $environnement = new Environnement();
                $environnement->setNomSite($dataEtape7['nomSite']);
                $environnement->setDistance($dataEtape7['distance']);
                $environnement->setEst($dataEtape7['est']);
                $environnement->setObservation($dataEtape7['observation']);

                // Récupérer l'utilisateur courant (par exemple, depuis la session)
                //$user = $session->get('currentUser'); // Assurez-vous que 'currentUser' existe dans la session
                $environnement->setUser($user);

                // Enregistrer dans la base de données
                $this->entityManager->persist($environnement);
                $this->entityManager->flush();

                $typeConstructionData = $session->get('etape8');

                // Si les données sont un objet, extrayez les informations nécessaires
                if ($typeConstructionData instanceof TypeConstruction) {
                    // Conversion de l'objet en tableau pour faciliter l'accès
                    $typeConstructionData = [
                        'user_id' => $typeConstructionData->getUser()->getId(),
                        'details' => array_map(function ($detail) {
                            return [
                                'designation' => $detail->getDesignation(),
                                'unite' => $detail->getUnite(),
                                'nombre' => $detail->getNombre(),
                            ];
                        }, $typeConstructionData->getDetails()->toArray())
                    ];
                }

                // Récupération et persistance comme dans le code précédent
                if (isset($typeConstructionData['user_id'])) {
                    $user = $entityManager->getRepository(User::class)->find($typeConstructionData['user_id']);
                } else {
                    throw new \Exception("Aucun ID d'utilisateur trouvé.");
                }

                $typeConstruction = new TypeConstruction();
                $typeConstruction->setUser($user);

                foreach ($typeConstructionData['details'] as $detailData) {
                    $detail = new TypeConstructionDetail();
                    $detail->setDesignation($detailData['designation']);
                    $detail->setUnite($detailData['unite']);
                    $detail->setNombre($detailData['nombre']);
                    $typeConstruction->addDetail($detail);
                }

                $entityManager->persist($typeConstruction);
                $entityManager->flush();
                //etape 7
                // Récupérer les données de la session
                $dataEtape9 = $session->get('etape9'); // Récupérer les données de l'étape 9

                if (is_object($dataEtape9)) {
                    $dataEtape9 = [
                        'nature' => $dataEtape9->getNature()
                    ];
                }
                // Assurez-vous que les données existent avant de les utiliser
                $natureOuvrage = new NatureOuvrage();
                $natureOuvrage->setNature($dataEtape9['nature']);

                // Récupérer l'utilisateur courant (par exemple, depuis la session)
                // $user = $session->get('currentUser'); // Assurez-vous que 'currentUser' existe dans la session
                $natureOuvrage->setUser($user);
                // dd($natureOuvrage);
                // Enregistrer dans la base de données
                $this->entityManager->persist($natureOuvrage);
                $this->entityManager->flush();


                //eta10
                $dataEtape10 = $session->get('etape10'); // Récupération des données de session
                if (is_object($dataEtape10)) {
                    $dataEtape10 = [
                        'planMasse' => $dataEtape10->getPlanMasse(),
                        'planEsquisse' => $dataEtape10->getPlanEsquisse(),
                        'planImmatriculation' => $dataEtape10->getPlanImmatriculation(),
                        'planAssainissement' => $dataEtape10->getPlanAssainissement(),
                        'certificatSituationJuridiqueTerrain' => $dataEtape10->getCertificatSituationJuridiqueTerrain()
                    ];
                }
                $planMasse = new PlanMasse();
                $planMasse->setPlanMasse($dataEtape10['planMasse'] ?? null);
                $planMasse->setPlanEsquisse($dataEtape10['planEsquisse'] ?? null);
                $planMasse->setPlanImmatriculation($dataEtape10['planImmatriculation'] ?? null);
                $planMasse->setPlanAssainissement($dataEtape10['planAssainissement'] ?? null);
                $planMasse->setCertificatSituationJuridiqueTerrain($dataEtape10['certificatSituationJuridiqueTerrain'] ?? null);

                // Associer à l'utilisateur si nécessaire
                $planMasse->setUser($user); // $user doit être l'entité User courante
                // dd($planMasse);
                // Persist et flush dans le gestionnaire d’entité
                $entityManager->persist($planMasse);
                $entityManager->flush();

                $dataEtape12 = $session->get('etape12'); // Récupération des données de session
                if (is_object($dataEtape12)) {
                    $dataEtape12 = [
                        'ravinalaSelection' => $dataEtape12->getRavinalaSelection(),
                        'etoileSelection' => $dataEtape12->getEtoileSelection()
                    ];
                }
                $categorieClassement = new CategorieClassement();
                $categorieClassement->setRavinalaSelection($dataEtape12['ravinalaSelection']);
                $categorieClassement->setEtoileSelection($dataEtape12['etoileSelection']);
                // dd($categorieClassement);

                // Associer à l'utilisateur si nécessaire
                $categorieClassement->setUser($user); // $user doit être l'entité User courante

                // Persist et flush dans le gestionnaire d’entité
                $entityManager->persist($categorieClassement);
                $entityManager->flush();
                //etape 10
                $dataEtape11 = $session->get('etape11'); // Récupération des données de session
                // dd($dataEtape11);
                if (is_null($dataEtape11)) {
                    $casDeLocation = null;
                } else {
                    if (is_object($dataEtape11)) {
                        $dataEtape11 = [
                            'nomBailleur' => $dataEtape11->getNomBailleur(),
                            'adresseBailleur' => $dataEtape11->getAdresseBailleur(),
                            'nomPreneur' => $dataEtape11->getNomPreneur(),
                            'adresseDePreneur' => $dataEtape11->getAdresseDePreneur(),
                            'dureeBailleur' => $dataEtape11->getDureeBailleur(),
                            'dateDebut' => $dataEtape11->getDateDebut(),
                            'dateFin' => $dataEtape11->getDateFin(),
                            'nomDuSignateur' => $dataEtape11->getNomDuSignateur(),
                            'dateDuSignateur' => $dataEtape11->getDateDuSignateur(),
                            'signataire' => $dataEtape11->getSignataire()
                        ];
                    }
                    $casDeLocation = new CasDeLocation();
                    $casDeLocation->setNomBailleur($dataEtape11['nomBailleur']);
                    $casDeLocation->setAdresseBailleur($dataEtape11['adresseBailleur']);
                    $casDeLocation->setNomPreneur($dataEtape11['nomPreneur']);
                    $casDeLocation->setAdresseDePreneur($dataEtape11['adresseDePreneur']);
                    $casDeLocation->setDureeBailleur($dataEtape11['dureeBailleur']);
                    if (is_string($dataEtape11['dateDebut'])) {
                        $casDeLocation->setDateDebut(new \DateTime($dataEtape11['dateDebut']));
                    } else {
                        $casDeLocation->setDateDebut($dataEtape11['dateDebut']);
                    }

                    if (is_string($dataEtape11['dateFin'])) {
                        $casDeLocation->setDateFin(new \DateTime($dataEtape11['dateFin']));
                    } else {
                        $casDeLocation->setDateFin($dataEtape11['dateFin']);
                    }

                    if (is_string($dataEtape11['dateDuSignateur'])) {
                        $casDeLocation->setDateDuSignateur(new \DateTime($dataEtape11['dateDuSignateur']));
                    } else {
                        $casDeLocation->setDateDuSignateur($dataEtape11['dateDuSignateur']);
                    }

                    $casDeLocation->setNomDuSignateur($dataEtape11['nomDuSignateur']);
                    $casDeLocation->setSignataire($dataEtape11['signataire']);
                    //  dd($casDeLocation);

                    $casDeLocation->setUser($user);

                    $entityManager->persist($casDeLocation);
                    $entityManager->flush();
                }



                $typeConstructionId = $typeConstruction?->getId();
                //dd($typeConstructionId);
                $renseignementTypeEntrepriseId = $renseignementTypeEntreprise?->getId();

                if (isset($dataEtape2['denominationSociale'])) {
                    $renseignementIndividuelleId = null;
                    // dd($renseignementIndividuelleId);
                }
                $renseignementIndividuelleId = $renseignementIndividuelle?->getId();
                // dd($renseignementIndividuelleId);

                // dd($renseignementCINId);

                // dd($renseignementEntrepriseId);


                $natureProjetId = $natureProjet?->getId();
                $relationActiviteId = $relationActivite?->getId();
                $lieuImplantationId = $lieuImplantation?->getId();
                $environnementId = $environnement?->getId();
                $natureOuvrageId = $natureOuvrage?->getId();
                $planMasseId = $planMasse?->getId();
                if (is_null($dataEtape11)) {
                    $casDeLocation = null;
                } else {
                    $casDeLocationId = $casDeLocation->getId();
                    $casDeLocation = $this->entityManager->getRepository(CasDeLocation::class)->find($casDeLocationId);
                }

                $categorieClassementId = $categorieClassement?->getId();
                $userId = $user?->getId();
                // dd($categorieClassementId);


                // Récupérer les entités correspondantes

                $maDemande = new MaDemande();



                $categorieClassement = $this->entityManager->getRepository(CategorieClassement::class)->find($categorieClassementId);
                $lieuImplantation = $this->entityManager->getRepository(LieuImplantation::class)->find($lieuImplantationId);
                $natureOuvrage = $this->entityManager->getRepository(NatureOuvrage::class)->find($natureOuvrageId);
                $natureProjet = $this->entityManager->getRepository(NatureProjet::class)->find($natureProjetId);
                $planMasse = $this->entityManager->getRepository(PlanMasse::class)->find($planMasseId);
                $relationActivite = $this->entityManager->getRepository(RelationActivite::class)->find($relationActiviteId);
                // dd($relationActivite);
                $user = $this->entityManager->getRepository(User::class)->find($userId);
                // dd($user);
                //echo $renseignementCINId;
                //  dd($user);
                //  dd(!empty($dataEtape3CIN));
                //print_r($renseignementCINId);
                /// dd($dataEtape3CIN);
                //  die();
                if (!empty($dataEtape3CIN)) {
                    // dd($renseignementCINId);
                    $renseignementCIN = $this->entityManager->getRepository(RenseignementCIN::class)->find($renseignementCINId);
                    //dd($renseignementCIN);
                    $maDemande->setIdRenseignementCIN($renseignementCIN);
                }

                $renseignementTypeEntreprise = $this->entityManager->getRepository(RenseignementTypeEntreprise::class)->find($renseignementTypeEntrepriseId);
                //  dd($renseignementTypeEntreprise);
                $maDemande->setIdRenseignementEntreprise($renseignementTypeEntreprise);

                if (!empty($dataEtape2['denominationSociale'])) {
                    $RenseignementEntreprise = $this->entityManager->getRepository(RenseignementEntreprise::class)->find($renseignementEntrepriseId);
                    //   dd($RenseignementEntreprise);
                    $maDemande->setIdRenseignementEntreprises($RenseignementEntreprise);
                } else {
                    $renseignementIndividuelle = $this->entityManager->getRepository(RenseignementIndividuelle::class)->find($renseignementIndividuelleId);
                    $maDemande->setIdResneignementIndividuelle($renseignementIndividuelle);
                }
                //    $renseignementVisa = $this->entityManager->getRepository(RenseignementVisa::class)->find($renseignementVisaId);

                $environnement = $this->entityManager->getRepository(Environnement::class)->find($environnementId);
                $typeConstruction = $this->entityManager->getRepository(TypeConstruction::class)->find($typeConstructionId);
                //   dd($typeConstruction);
                // Créer une nouvelle instance de MaDemande


                // dd($maDemande);
                $maDemande->setIdCasDeLocation($casDeLocation);
                //   dd($maDemande);
                $maDemande->setIdCategorieClassement($categorieClassement);
                $maDemande->setIdEnvironnement($environnement);
                $maDemande->setIdLieuImplantation($lieuImplantation);
                $maDemande->setIdNatureOuvrage($natureOuvrage);
                $maDemande->setIdNatureProjet($natureProjet);
                $maDemande->setIdPlanMasse($planMasse);
                $maDemande->setIdRelationActivite($relationActivite);
                // dd($maDemande);
                $maDemande->setIdUsers($user);
                //dd($maDemande);



                //dd($maDemande);
                if (!empty($dataEtape3['numPasseport'])) {
                    $renseignementVisa = $this->entityManager->getRepository(RenseignementVisa::class)->find($renseignementVisaId);
                    // dd($renseignementVisa);
                    $maDemande->setIdRenseignementVisa($renseignementVisa);
                }


                //  $maDemande->setIdRenseignementVisa($renseignementVisa);

                $maDemande->setIdTypeConstruction($typeConstruction);

                // dd($maDemande);

                $maTypeDeDemande = "Avis prealable";
                $maDemande->setMaTypeDeDemande($maTypeDeDemande);
                $status = "En Attente";
                $maDemande->setStatus($status);

                $dateMada = $DateService->getDateTimeMadagascar();
                $maDemande->setDateActuel($dateMada);
                //    dd($maDemande);



                try {
                    $entityManager->persist($maDemande);
                    $entityManager->flush();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

                $ResponsableDemande = new ResponsableDemande();
                $maDemandeID =  $maDemande->getId();
                // dd( $maDemande);
                $maDemande = $this->entityManager->getRepository(MaDemande::class)->find($maDemandeID);
                //  dd( $maDemande);
                $ResponsableDemande->setMaDemande($maDemande);

                $ResponsableDemande->setDRTM(false);
                $ResponsableDemande->setEDBM(false);
                $ResponsableDemande->setDAT(false);
                $ResponsableDemande->setDG(false);
                $ResponsableDemande->setSG(false);
                $ResponsableDemande->setMinistre(false);

                $entityManager->persist($ResponsableDemande);
                $entityManager->flush();


                $session->remove('etape1');
                $session->remove('etape2');
                $session->remove('etape3CIN');
                $session->remove('etape3Visa');
                $session->remove('etape4');
                $session->remove('etape5');
                $session->remove('etape6');
                $session->remove('etape7');
                $session->remove('etape8');
                $session->remove('etape9');
                $session->remove('etape10');
                $session->remove('etape11');
                $session->remove('etape12');

                // Stocker les données dans la session

                return $this->redirectToRoute('app_upload_pdf');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while processing your request.');
            }
        }

        return $this->render('AvisPrealable/Confiramtion.html.twig', []);
    }
}
