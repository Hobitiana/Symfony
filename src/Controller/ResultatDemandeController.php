<?php

namespace App\Controller;

use App\Entity\ResultatDemande;
use App\Form\ResultatDemandeType;
use App\Repository\ResultatDemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/resultat/demande')]
class ResultatDemandeController extends AbstractController
{
    #[Route('/', name: 'app_resultat_demande_index', methods: ['GET'])]
    public function index(ResultatDemandeRepository $resultatDemandeRepository): Response
    {
        return $this->render('resultat_demande/index.html.twig', [
            'resultat_demandes' => $resultatDemandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_resultat_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resultatDemande = new ResultatDemande();
        $form = $this->createForm(ResultatDemandeType::class, $resultatDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($resultatDemande);
            $entityManager->flush();

            return $this->redirectToRoute('app_resultat_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resultat_demande/new.html.twig', [
            'resultat_demande' => $resultatDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resultat_demande_show', methods: ['GET'])]
    public function show(ResultatDemande $resultatDemande): Response
    {
        return $this->render('resultat_demande/show.html.twig', [
            'resultat_demande' => $resultatDemande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_resultat_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ResultatDemande $resultatDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResultatDemandeType::class, $resultatDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_resultat_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resultat_demande/edit.html.twig', [
            'resultat_demande' => $resultatDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resultat_demande_delete', methods: ['POST'])]
    public function delete(Request $request, ResultatDemande $resultatDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resultatDemande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($resultatDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_resultat_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
