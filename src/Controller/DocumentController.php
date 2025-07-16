<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\User;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class DocumentController extends AbstractController
{
    #[Route('/document', name: 'app_document')]
    public function index(): Response
    {
        return $this->render('document/index.html.twig', [
            'controller_name' => 'DocumentController',
        ]);
    }
    #[Route('/upload', name: 'document_upload')]
    public function upload(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if ($file) {
                // Lire le fichier en tant que binaire
                $pdfData = file_get_contents($file->getPathname());
                $document->setPdfData($pdfData);
                $document->setFilename($file->getClientOriginalName());

                // Associer le document à l'utilisateur connecté
                $user = $security->getUser();
                $document->setUser($user);

                // Sauvegarder en base de données
                $entityManager->persist($document);
                $entityManager->flush();

                return $this->redirectToRoute('document_upload');
            }
        }

        return $this->render('document/uploadDocument.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/users-with-unprocessed-pdf', name: 'users_unprocessed_pdf')]
    public function listUsersWithUnprocessedPDF(UserRepository $userRepository): Response
    {
        // Récupérer les utilisateurs ayant des PDF non traités
        //$users = $userRepository->findUsersWithUnprocessedPDFs();
        $users = $userRepository->findUsersWithOnlyUnprocessedPDFs();

        return $this->render('document/listePDF.html.twig', [
            'users' => $users,
        ]);
    }
    /*
    #[Route('/user/{id}/view-pdf', name: 'view_user_pdf')]
    public function viewUserPdf(User $user): Response
    {
        // Récupérer les PDF non traités de l'utilisateur
        $unprocessedPdf = $user->getDocuments()->filter(function ($document) {
            return !$document->isProcessed();
        })->first();

        if (!$unprocessedPdf) {
            throw $this->createNotFoundException('Aucun PDF non traité trouvé pour cet utilisateur.');
        }

        // Afficher le PDF (en utilisant des headers spécifiques pour afficher le fichier)
        return new Response(stream_get_contents($unprocessedPdf->getPdfData()), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $unprocessedPdf->getFilename() . '"'
        ]);
    }
        */
}
