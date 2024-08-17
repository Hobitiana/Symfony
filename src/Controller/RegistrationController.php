<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class RegistrationController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EmailVerifier $emailVerifier;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EmailVerifier $emailVerifier, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, MailerInterface $mailer, UrlGeneratorInterface $urlGenerator): Response
    {
       
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            //Hash du mot de passe
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
    
            // Génération du token de vérification
            $user->setVerificationToken(Uuid::v4());
    
            // Enregistrement de l'utilisateur
            $this->entityManager->persist($user);
            $this->entityManager->flush();
    
// Envoi de l'email de vérification
$verificationUrl = $urlGenerator->generate('verify_email', ['token' => $user->getVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
$loginUrl = $urlGenerator->generate('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL);
$transport = new EsmtpTransport('smtp.gmail.com', 465, 'ssl');
$transport->setUsername('hobitianaandriamanantena@gmail.com');
$transport->setPassword('dqqc wzmh kivm john');

$mailer = new Mailer($transport);

$email = (new Email())
    ->from('hobitianaandriamanantena@gmail.com')
    ->to($user->getEmail())
    ->subject('Test Email')
    ->text("Voici votre lien de vérification: $verificationUrl\n\nEt voici le lien pour vous connecter: $loginUrl");

$mailer->send($email);
    
            return $this->redirectToRoute('registration_check_email');
        }
    
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
        
    

    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse email a été vérifiée.');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/verify-email', name: 'verify_email')]
    public function verifyEmail(Request $request, UserRepository $userRepository): Response
    {
        $token = $request->query->get('token');

        if (!$token) {
            throw $this->createNotFoundException('Le token de vérification est manquant.');
        }

        $user = $userRepository->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $user->setVerified(true); //niova
        $user->setVerificationToken(null);

        $this->entityManager->flush();

        return new Response('Votre email a été vérifié avec succès.');
    }
    //napina
    #[Route('/verify/email/url', name: 'verify_email_with_url', methods: ['POST'])]
    public function verifyEmailWithUrl(Request $request, UserRepository $userRepository): Response
    {
        $verificationUrl = $request->request->get('verificationUrl');
    
        // Extraire le token de l'URL (supposons qu'il soit au format '?token=XYZ')
        $token = parse_url($verificationUrl, PHP_URL_QUERY);
        parse_str($token, $queryParams);
        $token = $queryParams['token'] ?? null;
    
        if (!$token) {
            return new Response('URL de vérification invalide.', Response::HTTP_BAD_REQUEST);
        }
    
        $user = $userRepository->findOneBy(['verificationToken' => $token]);
    
        if (!$user) {
            return new Response('Utilisateur non trouvé.', Response::HTTP_NOT_FOUND);
        }
    
        $user->setVerified(true);
        $user->setVerificationToken(null);
    
        $this->entityManager->flush();
    
        return new Response('Votre email a été vérifié avec succès.');
    }
    #[Route('/check-email', name: 'registration_check_email')]
    public function checkEmail(): Response
    {
        return $this->render('registration/check_email.html.twig');
    }
}
