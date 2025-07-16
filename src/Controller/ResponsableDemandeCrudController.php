<?php

namespace App\Controller;

use App\Entity\ResponsableDemande;
use App\Form\ResponsableDemandeType;
use App\Repository\ResponsableDemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/responsable/demande/crud')]
class ResponsableDemandeCrudController extends AbstractController
{
    #[Route('/', name: 'app_responsable_demande_crud_index', methods: ['GET'])]
    public function index(ResponsableDemandeRepository $responsableDemandeRepository): Response
    {
        return $this->render('responsable_demande_crud/index.html.twig', [
            'responsable_demandes' => $responsableDemandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_responsable_demande_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $responsableDemande = new ResponsableDemande();
        $form = $this->createForm(ResponsableDemandeType::class, $responsableDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responsableDemande);
            $entityManager->flush();

            return $this->redirectToRoute('app_responsable_demande_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('responsable_demande_crud/new.html.twig', [
            'responsable_demande' => $responsableDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_responsable_demande_crud_show', methods: ['GET'])]
    public function show(ResponsableDemande $responsableDemande): Response
    {
        return $this->render('responsable_demande_crud/show.html.twig', [
            'responsable_demande' => $responsableDemande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_responsable_demande_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ResponsableDemande $responsableDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResponsableDemandeType::class, $responsableDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_responsable_demande_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('responsable_demande_crud/edit.html.twig', [
            'responsable_demande' => $responsableDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_responsable_demande_crud_delete', methods: ['POST'])]
    public function delete(Request $request, ResponsableDemande $responsableDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$responsableDemande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($responsableDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_responsable_demande_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
