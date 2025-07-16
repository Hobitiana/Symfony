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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer;

class RegistrationController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EmailVerifier $emailVerifier;
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;
    private Environment $twig;
    private $bodyRenderer;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher, 
        Environment $twig,
        MailerInterface $mailer, 
        EmailVerifier $emailVerifier, 
        BodyRendererInterface $bodyRenderer,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->emailVerifier = $emailVerifier;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->bodyRenderer = $bodyRenderer;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Generate verification token
            $user->setVerificationToken(Uuid::v4());

            // Set roles based on the email
            if ($user->getEmail() === 'mioratianalinah17@gmail.com') {
                $user->setRoles(['ROLE_USER', 'ROLE_SUPER_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }

            // Save the user
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Envoi de l'email de vérification
            $verificationUrl = $urlGenerator->generate('verify_email', ['token' => $user->getVerificationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
            $loginUrl = $urlGenerator->generate('app_login', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $transport = new EsmtpTransport('smtp.gmail.com', 465, 'ssl');
            $transport->setUsername('hobitianaandriamanantena@gmail.com');
            $transport->setPassword('dqqc wzmh kivm john');
            
            $mailer = new Mailer($transport);
            
            $email = (new TemplatedEmail())
                ->from('hobitianaandriamanantena@gmail.com')
                ->to($user->getEmail())
                ->subject('Vérification de votre adresse email')
                ->htmlTemplate('registration/verification.html.twig')
                ->context([
                    'user' => $user,
                    'verification_url' => $verificationUrl,
                    'login_url' => $loginUrl,
                ]);
              $this->bodyRenderer->render($email);
            $mailer->send($email);

            $this->addFlash('success', 'Un email de vérification vous a été envoyé. Veuillez vérifier votre boîte de réception.');
            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify-email', name: 'verify_email')]
    public function verifyEmail(Request $request, UserRepository $userRepository): Response
    {
        $token = $request->query->get('token');

        if (!$token) {
            $this->addFlash('error', 'Le token de vérification est manquant.');
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé.');
            return $this->redirectToRoute('app_register');
        }

        $user->setIsVerified(true);
       // $user->setVerificationToken(null);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/check-email', name: 'registration_check_email')]
    public function checkEmail(): Response
    {
        return $this->render('registration/check_email.html.twig');
    }
}
