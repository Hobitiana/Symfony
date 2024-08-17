<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository,Security $security): Response
    {
        // Récupère l'erreur de login s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupère le dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Vérifie si l'utilisateur existe et est vérifié
        $user = $userRepository->findOneBy(['email' => $lastUsername]);
//var_dump($user);
if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
  
    if ($user && !$user->isVerified()) {
    
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    // Redirige vers le tableau de bord si l'utilisateur est vérifié
    return new RedirectResponse($this->generateUrl('dashboard'));
}

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
       
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        // Assurez-vous que seul un utilisateur authentifié peut accéder à ce point
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Affiche la page du tableau de bord
        return $this->render('dashboard.html.twig');
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
