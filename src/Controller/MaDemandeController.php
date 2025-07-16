<?php

namespace App\Controller;

use App\Entity\MaDemande;
use App\Form\MaDemandeType;
use App\Repository\MaDemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ma/demande')]
class MaDemandeController extends AbstractController
{
    #[Route('/', name: 'app_ma_demande_index', methods: ['GET'])]
    public function index(MaDemandeRepository $maDemandeRepository): Response
    {
        return $this->render('ma_demande/index.html.twig', [
            'ma_demandes' => $maDemandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ma_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $maDemande = new MaDemande();
        $form = $this->createForm(MaDemandeType::class, $maDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maDemande);
            $entityManager->flush();

            return $this->redirectToRoute('app_ma_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ma_demande/new.html.twig', [
            'ma_demande' => $maDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ma_demande_show', methods: ['GET'])]
    public function show(MaDemande $maDemande): Response
    {
        return $this->render('ma_demande/show.html.twig', [
            'ma_demande' => $maDemande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ma_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MaDemande $maDemande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaDemandeType::class, $maDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ma_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ma_demande/edit.html.twig', [
            'ma_demande' => $maDemande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ma_demande_delete', methods: ['POST'])]
    public function delete(Request $request, MaDemande $maDemande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maDemande->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($maDemande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ma_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
