<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig');
    }
    #[Route('/Apropos/contact', name: 'app_contact_apropos')]
    public function contact(): Response
    {
        return $this->render('contact/contact.html.twig');
    }
    #[Route('/contact/submit', name: 'contact_submit', methods: ['POST'])]
    public function contactSubmit(Request $request): Response
    {
        // Traitement des données du formulaire de contact
        // Exemple : Envoyer un email
        $name = $request->get('name');
        $email = $request->get('email');
        $message = $request->get('message');

        // Simulez une réponse ou redirigez
        $this->addFlash('success', 'Merci pour votre message ! Nous vous répondrons rapidement.');
        return $this->redirectToRoute('app_contact_apropos');
    }
}
