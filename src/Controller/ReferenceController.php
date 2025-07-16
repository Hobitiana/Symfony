<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use App\Repository\ResultatDemandeRepository;
use App\Form\ReferenceType;
use App\Entity\DesignationReference;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class ReferenceController extends AbstractController
{
    #[Route('/Autorisation-Ouverture', name: 'Affiche_dossierAO')]
    public function profile(): Response
    {
        $user = $this->getUser();

        return $this->render('AvisOuverture/Accueil.html.twig');
    }
    #[Route('/AvisOuverture/reference', name: 'app_reference')]
    public function index(HttpFoundationRequest $request, SessionInterface $session, EntityManagerInterface $entityManager,ResultatDemandeRepository $ResultatDemandeRepository): Response
    {
        $reference = new DesignationReference();


        $form = $this->createForm(ReferenceType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $reference->setUser($user);
            $userId = $user->getId();

            $donneReferenceUser = $ResultatDemandeRepository->findReferenceByUser($user);
     
            $getReference=$reference->getReference();

            if ($donneReferenceUser) {
                $ref = $donneReferenceUser->getReference();

                if ($ref == $getReference) {
                   
                                        $reference->getDatesignature();
                                        $reference->getSignataire();
                                    $entityManager->persist($reference);
                                        $entityManager->flush();
                    $session->set('reference', $getReference);
                    return $this->redirectToRoute('Affiche_dossierAO');

                }
                else {
                    return $this->redirectToRoute('affichage_NatureDeDeamnde');
                }
            }   
          
            return $this->redirectToRoute('affichage_NatureDeDeamnde'); // Adjust the redirect route as needed
        }
        return $this->render('AvisOuverture/reference/index.html.twig', [
            'formreference' => $form->createView(),
        ]);
    }
}
