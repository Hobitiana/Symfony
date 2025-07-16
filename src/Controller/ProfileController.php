<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    // #[Route('/profile/{id}', name: 'app_profile_edit')]
    // public function editProfile(int $id, Request $request, EntityManagerInterface $entityManager): Response
    // {
     
      
    //     $user = $entityManager->getRepository(User::class)->find($id);

    //     if (!$user) {
    //         throw $this->createNotFoundException('Utilisateur non trouvé.');
    //     }

    //     // Vérifiez si l'utilisateur connecté est autorisé à modifier ce profil
    //     $currentUser = $this->getUser();
    //     if ($user !== $currentUser) {
    //         throw $this->createAccessDeniedException('Vous ne pouvez modifier que votre propre profil.');
    //     }
    //     // Récupérer l'ID de l'utilisateur
       
       
    //    // $form = $this->createForm(Type::class, $user);

    //    // $form->handleRequest($request);
        
    //     if ($request->isMethod('POST')) {
    //       //  $imageFile = $form->get('image')->getData();

    //         // if ($imageFile) {
    //         //     $newFilename = uniqid().'.'.$imageFile->guessExtension();
    //         //     $imageFile->move($this->getParameter('profile_images_directory'), $newFilename);
    //         //     $user->setImage($newFilename);
    //         // }

    //     // $entityManager->persist($user);
    //   //  dd($user);

    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_profile');
    //     }

    //     return $this->render('profile/index.html.twig', [
    //         'form' => $form->createView(),
    //         'user' => $user,
    //     ]);
    // }
    #[Route('/profile/{id}', name: 'app_profile_edit')]
public function editProfile(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    // Récupérez l'utilisateur par ID
    $user = $entityManager->getRepository(User::class)->find($id);

    // Vérifiez si l'utilisateur existe
    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé.');
    }

    // Vérifiez si l'utilisateur connecté est autorisé à modifier ce profil
    $currentUser = $this->getUser();
    if ($user !== $currentUser) {
        throw $this->createAccessDeniedException('Vous ne pouvez modifier que votre propre profil.');
    }

    // Traitez la requête POST
    if ($request->isMethod('POST')) {
        // Récupérez les données du formulaire
        $data = $request->request->all();

        // Mettez à jour les propriétés de l'utilisateur
        $user->setNom($data['nom']);
        $user->setPrenoms($data['prenom']);
        $user->setEmail($data['email']);
        $user->setEntreprise($data['entreprise']);
        $user->setVille($data['ville']);
        $user->setAdresse($data['adresse']);
        $user->setTelephone($data['telephone']);
        $user->setCodePostal($data['codeZip']);
        $user->setRegion($data['region']);
        $user->setPays($data['country']);

        // Si une image est téléchargée, gérez le téléchargement ici
        $imageFile = $request->files->get('image'); // Assurez-vous que le nom correspond au champ du formulaire

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            // Déplacez l'image
            $imageFile->move(
                $this->getParameter('profile_images_directory'),
                $newFilename
            );

            // Mettez à jour l'image dans l'utilisateur
            $user->setImage($newFilename);
        }

        // Persist et flush
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirigez vers la page de profil ou affichez un message de succès
        return $this->redirectToRoute('app_profile');
    }

    return $this->render('profile/edit.html.twig', [
        'user' => $user,
    ]);
}


    // #[Route('/profile/delete', name: 'app_profile_delete')]
    // public function deleteProfile(EntityManagerInterface $entityManager): Response
    // {
    //     $user = $this->getUser();

    //     // Supprimer l'image de profil si elle existe
    //     if ($user->getImage()) {
    //         $filesystem = new Filesystem();
    //         $filesystem->remove($this->getParameter('profile_images_directory') . '/' . $user->getImage());
    //     }

    //     // Supprimer l'utilisateur
    //     $entityManager->remove($user);
    //     $entityManager->flush();

    //     // Rediriger après suppression, peut-être vers la page d'accueil ou de connexion
    //     return $this->redirectToRoute('app_logout');
    // }

   
    #[Route('/profile/change-password/{id}', name: 'app_profile_change_password')]
    public function changePassword(Request $request, int $id, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
         // Vérifiez que l'utilisateur est connecté
    if (!$this->getUser()) {
        throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
    }

    // Récupérer l'utilisateur par ID
    $user = $entityManager->getRepository(User::class)->find($id);

    // Vérifiez si l'utilisateur existe
    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé.');
    }

    // Vérifiez si l'utilisateur a accès à cette action
    if ($user !== $this->getUser()) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier ce profil.');
    }

        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $currentPassword = $request->request->get('currentPassword');
            $newPassword = $request->request->get('newPassword');
            $confirmPassword = $request->request->get('confirmPassword');

            // Vérifier le mot de passe actuel
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
                return $this->redirectToRoute('app_profile_change_password', ['id' => $user->getId()]);
            }

            // Vérifier si le nouveau mot de passe correspond à la confirmation
            if ($newPassword !== $confirmPassword) {
                $this->addFlash('error', 'Le nouveau mot de passe et la confirmation ne correspondent pas.');
                return $this->redirectToRoute('app_profile_change_password', ['id' => $user->getId()]);
            }

            // Changer le mot de passe de l'utilisateur
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');

            return $this->redirectToRoute('app_profile'); // Redirection vers la vue du profil
        }

        // Rendu de la vue (si le formulaire est soumis)
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}


