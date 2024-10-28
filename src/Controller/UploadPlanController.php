<?php

namespace App\Controller;

use App\Entity\PlanMasse;
use App\Form\PlanMasseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\DesignationConstructionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadPlanController extends AbstractController
{
    #[Route('/AvisPrealable/PlanMasse/', name: 'affichage_UploadFichier')]
    public function new(HttpFoundationRequest $request, EntityManagerInterface $entityManager): Response
    {
        $planMasse = new PlanMasse();
        $form = $this->createForm(PlanMasseType::class, $planMasse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des fichiers uploadés
            $uploadedFiles = ['planMasse', 'planEsquisse', 'planImmatriculation', 'planAssainissement', 'certificatSituationJuridiqueTerrain'];

            foreach ($uploadedFiles as $fileField) {
                $uploadedFile = $form->get($fileField)->getData();

                if ($uploadedFile) {
                    // Lire le contenu du fichier et le stocker en tant que BLOB
                    $fileContent = file_get_contents($uploadedFile->getPathname());

                    // Utilisation de la méthode setter pour enregistrer le BLOB
                    $setter = 'set' . ucfirst($fileField);
                    $planMasse->$setter($fileContent);
                }
            }
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $planMasse->setUser($user);  
            // Sauvegarde de l'entité dans la base de données
            $entityManager->persist($planMasse);
            $entityManager->flush();

            return $this->redirectToRoute('affichage_CasDeLocation');
        }

        return $this->render('AvisPrealable/UploadPlan.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /*
    #[Route('/AvisPrealable/PlanMasse/', name: 'affichage_UploadFichier')]
    public function index(HttpFoundationRequest $request, EntityManagerInterface $entityManager,DesignationConstructionRepository $designationRepo): Response
    {
        $planMasse = new PlanMasse();
        $form = $this->createForm(PlanMasseType::class, $planMasse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des fichiers non mappés
            foreach (['planMasse', 'planEsquisse', 'planImmatriculation', 'planAssainissement', 'certificatSituationJuridiqueTerrain'] as $field) {
                $uploadedFile = $form->get($field)->getData();
                if ($uploadedFile) {
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();

                    // Déplace le fichier dans le répertoire où sont stockés les fichiers
                    try {
                        $uploadedFile->move(
                            $this->getParameter('uploads_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // Gérer les exceptions si quelque chose se passe mal pendant le déplacement du fichier
                    }

                    // Mettez à jour l'entité `PlanMasse` pour stocker le nom du fichier au lieu de son contenu
                    $setter = 'set' . ucfirst($field);
                    $planMasse->$setter($newFilename);
                }
            }
            $user = $this->getUser(); // Récupère l'utilisateur connecté
            $planMasse->setUser($user);  
            $entityManager->persist($planMasse);
            $entityManager->flush();
            return $this->redirectToRoute('affichage_UploadFichier'); // Adjust the redirect route as needed
        }
        return $this->render('AvisPrealable/UploadPlan.html.twig', [
            'form' => $form->createView(),
        ]);
}
*/

}