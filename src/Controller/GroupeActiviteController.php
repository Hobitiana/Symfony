<?php

namespace App\Controller;

use App\Entity\GroupeActivite1;
use App\Entity\Activite1;

use App\Entity\RelationActivite;
use App\Form\GroupeActivite1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RelationActiviteRepository;
use App\Repository\GroupeActivite1Repository;
use App\Repository\Activite1Repository;
use App\Service\EtapeService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GroupeActiviteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/groupeactivite1/save", name: "save_groupeactivite1", methods: ['POST'])]
    public function saveGroupeActivite1(HttpFoundationRequest $request, SessionInterface $session, EntityManagerInterface $entityManager, RelationActiviteRepository $relationRepository, GroupeActivite1Repository $groupeActivite1Repository, Activite1Repository $activite1Repository): Response
    {
/*
        $data = $request->request->all();
        //  dd($data);
        $action = $request->get('action');

        try {
            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape4');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_NatureProjet');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next') {

*/

                $IDGroupeActivite = $request->request->get('groupeActivite1');
                $IDActivite = $request->request->get('activite1');


                $groupeActivite = $groupeActivite1Repository->find($IDGroupeActivite);
                $activite = $activite1Repository->find($IDActivite);


                if (!$groupeActivite || !$activite) {
                    throw $this->createNotFoundException('L\'une des entités spécifiées n\'existe pas.');
                }


                $nomGroupeActivite = $groupeActivite->getNom();
                $nomActivite = $activite->getNom();

                $relationActivite = new RelationActivite();

                $relationActivite->setNomGroupe($nomGroupeActivite);
                $relationActivite->setNomActivite($nomActivite);
                $relationActivite->setUser($this->getUser());  // Assuming you're using a logged-in user


                $session->set('etape5', $relationActivite);
                return $this->redirectToRoute('Affiche_Lieu');
         /*   }
        } catch (\Exception $e) {
            // Gérer les erreurs
            dd($e);
            return $this->redirectToRoute('Affiche_Lieu');
        }
        return $this->redirectToRoute('Affiche_Lieu'); */
    } 
    /*
            // Si aucune action n'est valide, lever une exception
            throw new \Exception("Action invalide");
        } catch (\Exception $e) {
            // Gérer les erreurs
            dd($e);
        } 
    } */




    #[Route('/AvisPrealable/GroupeActivite', name: 'Affiche_GroupeActivite1')]
    public function index(HttpFoundationRequest $request, EtapeService $etapesService, SessionInterface $session): Response
    {
        $GroupeActivite1 = new GroupeActivite1();

        $form = $this->createForm(GroupeActivite1Type::class, $GroupeActivite1);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $action = $request->get('action'); // Récupérer le bouton cliqué

            if ($action === 'back') {
                // Supprimer les données de session pour cette étape
                $session->remove('etape4');

                // Rediriger vers l'étape précédente
                return $this->redirectToRoute('affichage_NatureProjet');
            }

            // Si le bouton "Suivant" est cliqué, valider le formulaire
            if ($action === 'next' &&  $form->isValid()) {
                // Persist the GroupeActivite1 entity
                $this->entityManager->persist($GroupeActivite1);

                // Now persist the RelationActivite entity
                $relationActivite = new RelationActivite();
                $relationActivite->setNomActivite($GroupeActivite1->getNom());
                $relationActivite->setNomGroupe($GroupeActivite1->getNom());
                $user = $this->getUser();
                $relationActivite->setUser($user);
                // $this->entityManager->persist($relationActivite);

                // Flush both entities
                // $this->entityManager->flush();
                $session->set('etape5', $relationActivite);
                // dd($dataGroupeActivite);
                dd($session->get('etape5'));

                return $this->redirectToRoute('Affiche_Lieu');
            }
        }
        $groupeActivites = $this->entityManager->getRepository(GroupeActivite1::class)->findAll();

        return $this->render('AvisPrealable/GroupeActivite.html.twig', [
            'form' => $form->createView(),
            'groupeActivite1s' => $groupeActivites, // Fix typo here from $groupeActivite1s to $groupeActivites
            'etapes' => $etapesService->getEtapes(),
            'etape_courante' => 5,
        ]);
    }


    #[Route('/AvisPrealable/activites', name: 'get_activites', methods: ['GET'])]
    public function getActivites(HttpFoundationRequest $request): JsonResponse
    {
        $groupeActiviteId = $request->query->get('groupeActivite1Id');

        if (!$groupeActiviteId) {
            return new JsonResponse(['error' => 'No groupeActiviteId provided'], Response::HTTP_BAD_REQUEST);
        }

        $activites = $this->entityManager->getRepository(Activite1::class)->findBy(['groupeActivite1' => $groupeActiviteId]);

        if (!$activites) {
            return new JsonResponse([], Response::HTTP_OK);  // Return an empty array if no activites found
        }

        $data = [];
        foreach ($activites as $activite) {
            $data[] = [
                'id' => $activite->getId(),
                'name' => $activite->getNom(),
            ];
        }

        return new JsonResponse($data);
    }
}
