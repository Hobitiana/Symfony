<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\District;
use App\Entity\Fokotany;
use App\Entity\LieuImplantation;
use App\Entity\Region;
use App\Form\LieuImplantationType;
use App\Repository\CommuneRepository;
use App\Repository\DistrictRepository;
use App\Repository\FokotanyRepository;
use App\Repository\RegionRepository;
use App\Service\EtapeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LieuImplantationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/lieu-implantation/save", name: "save_lieu_implantation", methods: ['POST'])]
    public function saveLieuImplantation(HttpFoundationRequest $request, SessionInterface $session, EntityManagerInterface $em, RegionRepository $regionRepository, DistrictRepository $districtRepository, CommuneRepository $communeRepository, FokotanyRepository $fokotanyRepository): Response
    {
        $regionId = $request->request->get('regionId');
        $districtId = $request->request->get('districtId');
        $communeId = $request->request->get('communeId');
        $fokotanyId = $request->request->get('fokotanyId');
        $adresse = $request->request->get('adresse');

        $region = $regionRepository->find($regionId);
        $district = $districtRepository->find($districtId);
        $commune = $communeRepository->find($communeId);
        $fokotany = $fokotanyRepository->find($fokotanyId);

        // Create a new LieuImplantation entity
        $lieuImplantation = new LieuImplantation();
        $lieuImplantation->setRegion($region ? $region->getName() : null);
        $lieuImplantation->setDistrict($district ? $district->getName() : null);
        $lieuImplantation->setCommune($commune ? $commune->getName() : null);
        $lieuImplantation->setFokotany($fokotany ? $fokotany->getName() : null);
        $lieuImplantation->setAdresse($adresse);

        $user = $this->getUser(); // Récupère l'utilisateur connecté
        $lieuImplantation->setUser($user);
        // $em->persist($lieuImplantation);
        //$em->flush();


        // Stocker les données dans la session
        $session->set('etape6', $lieuImplantation);
        // Rediriger ou afficher un message de succès
        return $this->redirectToRoute('affichage_Environnement');
    }
    #[Route('/AvisPrealable/LieuImplantation', name: 'Affiche_Lieu')]
    public function index(HttpFoundationRequest $request, EtapeService $etapesService, SessionInterface $session): Response
    {
        // Crée une nouvelle instance de LieuImplantation
        $lieuImplantation = new LieuImplantation();

        // Crée le formulaire en utilisant le form type défini
        $form = $this->createForm(LieuImplantationType::class, $lieuImplantation);

        // Gère la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape5');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('Affiche_GroupeActivite1');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                // Si le formulaire est soumis et valide, persistons les données dans la base de données
                $user = $this->getUser(); // Récupère l'utilisateur connecté
                $lieuImplantation->setUser($user);
                // $this->entityManager->persist($lieuImplantation);
                //$this->entityManager->flush();
                $dataLieu = $form->getData();
                // Stocker les données dans la session
                $session->set('etape6', $dataLieu);

                // Redirige vers une autre page ou affiche un message de succès
                return $this->redirectToRoute('affichage_Environnement');
            }
        }
        // Récupère toutes les régions pour l'affichage dans le formulaire
        $regionRepository = $this->entityManager->getRepository(Region::class);
        $regions = $regionRepository->findAll();

        // Affiche le formulaire
        return $this->render('AvisPrealable/LieuImplantation.html.twig', [
            'form' => $form->createView(),
            'regions' => $regions,
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 6,
        ]);
    }
    #[Route('/AvisPrealable/districts', name: 'get_districts', methods: ['GET'])]
    public function getDistricts(HttpFoundationRequest $request): JsonResponse
    {
        $regionId = $request->query->get('regionId');

        if (!$regionId) {
            return new JsonResponse(['error' => 'No regionId provided'], Response::HTTP_BAD_REQUEST);
        }

        $districts = $this->entityManager->getRepository(District::class)->findBy(['region' => $regionId]);

        $data = [];
        foreach ($districts as $district) {
            $data[] = [
                'id' => $district->getId(),
                'name' => $district->getName(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/AvisPrealable/communes', name: 'get_communes', methods: ['GET'])]
    public function getCommunes(HttpFoundationRequest $request): JsonResponse
    {
        $districtId = $request->query->get('districtId');

        if (!$districtId) {
            return new JsonResponse(['error' => 'No districtId provided'], Response::HTTP_BAD_REQUEST);
        }

        $communes = $this->entityManager->getRepository(Commune::class)->findBy(['district' => $districtId]);

        $data = [];
        foreach ($communes as $commune) {
            $data[] = [
                'id' => $commune->getId(),
                'name' => $commune->getName(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/AvisPrealable/fokotanys', name: 'get_fokotanys', methods: ['GET'])]
    public function getFokotanys(HttpFoundationRequest $request): JsonResponse
    {
        $communeId = $request->query->get('communeId');

        if (!$communeId) {
            return new JsonResponse(['error' => 'No communeId provided'], Response::HTTP_BAD_REQUEST);
        }

        $fokotanies = $this->entityManager->getRepository(Fokotany::class)->findBy(['commune' => $communeId]);

        $data = [];
        foreach ($fokotanies as $fokotany) {
            $data[] = [
                'id' => $fokotany->getId(),
                'name' => $fokotany->getName(),
            ];
        }

        return new JsonResponse($data);
    }
}
