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

class GroupeActiviteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    } 

    #[Route("/groupeactivite1/save", name: "save_groupeactivite1", methods: ['POST'])]
    public function saveGroupeActivite1(HttpFoundationRequest $request, EntityManagerInterface $entityManager ,RelationActiviteRepository $relationRepository,GroupeActivite1Repository $groupeActivite1Repository,Activite1Repository $activite1Repository ): Response
    {
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
    
        $entityManager->persist($relationActivite);
        $entityManager->flush();
    
      
        return $this->redirectToRoute('Affiche_Lieu');
        
    }
    

    

    #[Route('/AvisPrealable/GroupeActivite', name: 'Affiche_GroupeActivite1')]
    public function index(HttpFoundationRequest $request): Response
    {
        $GroupeActivite1 = new GroupeActivite1();
    
        $form = $this->createForm(GroupeActivite1Type::class, $GroupeActivite1);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
          // Persist the GroupeActivite1 entity
          $this->entityManager->persist($GroupeActivite1);
          
          // Now persist the RelationActivite entity
          $relationActivite = new RelationActivite();
          $relationActivite->setNomActivite($GroupeActivite1->getNom());
          $relationActivite->setNomGroupe($GroupeActivite1->getNom());
          $user = $this->getUser(); 
          $relationActivite->setUser($user);
          $this->entityManager->persist($relationActivite);
          
          // Flush both entities
          $this->entityManager->flush();
      
          return $this->redirectToRoute('Affiche_Lieu');
      }
      
    
        $groupeActivites = $this->entityManager->getRepository(GroupeActivite1::class)->findAll();
    
        return $this->render('AvisPrealable/GroupeActivite.html.twig', [
            'form' => $form->createView(),
            'groupeActivite1s' => $groupeActivites, // Fix typo here from $groupeActivite1s to $groupeActivites
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
