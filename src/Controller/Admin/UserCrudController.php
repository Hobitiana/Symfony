<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;
    private MailerInterface $mailer;
    private $requestStack;
    private $entityManager;
    private $bodyRenderer;

    public function __construct(UserPasswordHasherInterface $passwordHasher,BodyRendererInterface $bodyRenderer, RequestStack $requestStack, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->passwordHasher = $passwordHasher;
        $this->mailer = $mailer;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->bodyRenderer = $bodyRenderer;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des utilisateurs')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un utilisateur')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un utilisateur');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield FormField::addTab('Informations de base'),
            yield IdField::new('id')->onlyOnIndex(),
            yield TextField::new('email', 'Email')->setRequired(true),
           /* yield TextField::new('password', 'Mot de passe')
                ->setFormType(\Symfony\Component\Form\Extension\Core\Type\PasswordType::class)
                ->setRequired(true)
                ->onlyOnForms(),// Utiliser un champ de mot de passe en clair pour la saisie
          */  yield TextField::new('nom', 'Nom de famille')->hideOnIndex(),
            yield TextField::new('prenoms', 'Prénoms')->hideOnIndex(),
            yield TextField::new('entreprise', 'Entreprise')->hideOnIndex(),
            yield FormField::addTab('Informations de contact'),
            yield TextField::new('ville', 'Ville')->hideOnIndex(),
            yield TextField::new('adresse', 'Adresse')->hideOnIndex(),
            yield TextField::new('telephone', 'Téléphone')->hideOnIndex(),
            yield TextField::new('region', 'Région')->hideOnIndex(),
            yield TextField::new('pays', 'Pays')->hideOnIndex(),
            yield TextField::new('codePostal', 'Code postal')->hideOnIndex(),
            yield FormField::addTab('Informations supplémentaires'),
            yield ImageField::new('image', 'Image de profil')
                ->setUploadDir('public/uploads/profile_images/')
                ->setBasePath('/uploads/profile_images/')
                ->setRequired(false)
                ->hideOnIndex(),
            yield BooleanField::new('isVerified', 'Vérifié')->setRequired(true),
            yield ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                    'USER' => 'ROLE_USER',
                    'DRTM' => 'ROLE_DRTM',
                    'EDBM' => 'ROLE_EDBM',
                    'DAT' => 'ROLE_DAT',
                    'DG' => 'ROLE_DG',
                    'SG' => 'ROLE_SG',
                    'Ministre' => 'ROLE_MINISTRE',
                    'DNQ' => 'ROLE_DNQ',
                ])
                ->allowMultipleChoices(true)
                ->renderExpanded(true)
                ->setRequired(true),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $approveAction = Action::new('approve', 'Approuver')
        ->linkToCrudAction('approveUser');

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Action::INDEX, $approveAction)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action
                    ->setLabel('Créer et ajouter une autre')
                    ->setIcon('fa fa-plus');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel('Créer')
                    ->setIcon('fa fa-check');
            })
            ->disable(Action::NEW)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel('Modifier un utilisateur')
                    ->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel('Supprimer un utilisateur')
                    ->setIcon('fa fa-trash');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setLabel('Voir un utilisateur')
                    ->setIcon('fa fa-eye');
            });
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }

        if (!empty($entityInstance->getPassword())) {
            // Hacher le mot de passe et l'assigner
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
            $entityInstance->setPassword($hashedPassword);

        }

        // Enregistrer l'utilisateur
        parent::persistEntity($entityManager, $entityInstance);
    }
    public function approveUser(): RedirectResponse
    {
        $user = $this->getUserFromRequest();
        if ($user) {
            $user->setIsVerified(true);
            $this->entityManager->flush();
           // dd("tonga ato");
            $this->sendEmail($user, 'Votre compte a été approuvé');
        }
        return $this->redirect($this->generateUrl('admin'));
         // return User::class;
    }

    private function getUserFromRequest(): ?User
    {
        $id = $this->requestStack->getCurrentRequest()->query->get('entityId');
        return $this->entityManager->getRepository(User::class)->find($id);
    }
    private function sendEmail(User $user, string $message)
{
    try {
        /*
        $email = (new Email())
            ->from('hobitianaandriamanantena@gmail.com')
            ->to($user->getEmail())
            ->subject($message)
            ->text($message);
        $this->mailer->send($email);
       */
        $transport = new EsmtpTransport('smtp.gmail.com', 465, 'ssl');
        $transport->setUsername('hobitianaandriamanantena@gmail.com');
        $transport->setPassword('dqqc wzmh kivm john');

        $mailer = new Mailer($transport);

        $email = (new TemplatedEmail())
            ->from('hobitianaandriamanantena@gmail.com')
            ->to($user->getEmail())
            ->subject($message)
            ->text($message);

                     $this->bodyRenderer->render($email);

                     $mailer->send($email);

            } catch (\Exception $e) {
                // Enregistrer l’erreur dans les logs de Symfony
                $this->addFlash('danger', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
            }
        }
}
