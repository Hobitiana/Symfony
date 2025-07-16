<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\LoginAdminType;
use App\Repository\DesignationConstructionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    #[Route('/dashboard/admin', name: 'formulaire_login')]
public function AdminDash(HttpFoundationRequest $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
    // Crée un nouvel objet Admin pour le formulaire de login
    $form = $this->createForm(LoginAdminType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupère les données du formulaire
        $email = $form->get('email')->getData();
        $password = $form->get('password')->getData();

        // Rechercher l'utilisateur via l'email
        $adminRepo = $entityManager->getRepository(Admin::class);
        $adminFromDb = $adminRepo->findOneBy(['email' => $email]);
        $password = $adminRepo->findOneBy(['password' => sha1($password)]);
       // var_dump($adminFromDb);
       // var_dump($passwordHasher->isPasswordValid($adminFromDb, $password));
    //  die;
        // Si l'utilisateur est trouvé et que le mot de passe est valide
        if ($adminFromDb && $password ) {
            // Vérifie le rôle de l'utilisateur
            $roles = $adminFromDb->getRoles();
          //  var_dump($roles);
          // die;
            if (in_array('ROLE_SUPER_ADMIN', $roles)) {
                return $this->redirectToRoute('superadmin_dashboard');
            } elseif (in_array('ROLE_ADMIN', $roles)) {
                return $this->redirectToRoute('admin');
            }
        } else {
            // Afficher un message d'erreur en cas d'échec de connexion
            $this->addFlash('error', 'Email ou mot de passe incorrect.');
        }
    }

    return $this->render('admin/login.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
