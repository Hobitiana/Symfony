<?php

namespace App\Controller\Admin;

use App\Entity\User;

use App\Entity\MaDemande;
use App\Entity\ResponsableDemande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

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

class ResponsableDemandeCrudController extends AbstractCrudController
{
    private MailerInterface $mailer;
    private $requestStack;
    private $entityManager;
    private $bodyRenderer;

    public static function getEntityFqcn(): string
    {
        return ResponsableDemande::class;
    }
public function __construct(BodyRendererInterface $bodyRenderer, RequestStack $requestStack, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {

        $this->mailer = $mailer;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->bodyRenderer = $bodyRenderer;
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Demandes')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un demande')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un demande');
    }

    public function configureFields(string $pageName): iterable
    {
        
        $fields = [
            IdField::new('maDemande.idUsers.id', 'ID')->onlyOnIndex(),
       TextField::new('maDemande.idUsers.email', 'Prénom de l\'Utilisateur')->onlyOnIndex(),

            // Afficher l'ID de la demande liée (relation ManyToOne avec MaDemande)
   
            // Exemple : Ajouter une propriété spécifique de MaDemande
             TextField::new('maDemande.maTypeDeDemande', 'Type de Demande')
                ->onlyOnIndex(),
            TextField::new('maDemande.status', 'Status')
                ->onlyOnIndex(),    
        ]; 
    
        // Ajouter un champ conditionnellement selon le rôle
        if ($this->isGranted('ROLE_EDBM')) {
            $fields[] = BooleanField::new('EDBM', 'EDBM');
         
        }
        if ($this->isGranted('ROLE_DRTM')) {
            $fields[] = BooleanField::new('DRTM', 'DRTM');
       
        }
        if ($this->isGranted('ROLE_DAT')) {
            $fields[] = BooleanField::new('DAT', 'DAT');
 
        }
        if ($this->isGranted('ROLE_DG')) {
            $fields[] = BooleanField::new('DG', 'DG');
 
        }
    
        // Retourner les champs
        return $fields;
        /*
        return [
         
            yield BooleanField::new('DRTM', 'DRTM'),
              if ($this->isGranted('ROLE_EDBM')) {
                      yield BooleanField::new('EDBM', 'EDBM'),
                 }
            yield BooleanField::new('DAT', 'DAT'),
            yield BooleanField::new('DG', 'DG'),
            yield BooleanField::new('SG', 'SG'),
            yield BooleanField::new('Ministre', 'Ministre'),
    
            // Relation avec MaDemande
            yield TextField::new('maDemande.idUsers.prenoms', 'Prénom de l\'Utilisateur')->onlyOnIndex(),

            // Afficher l'ID de la demande liée (relation ManyToOne avec MaDemande)
   
            // Exemple : Ajouter une propriété spécifique de MaDemande
            yield TextField::new('maDemande.maTypeDeDemande', 'Type de Demande')
                ->onlyOnIndex(),
            yield TextField::new('maDemande.status', 'Status')
                ->onlyOnIndex(),    
            ]; */
    }
    public function configureActions(Actions $actions): Actions
    {
        $approveAction = Action::new('approve', 'Approuver')
        ->linkToCrudAction('approveUser')
        ->setHtmlAttributes(['data-entity-id' => 'id']);
        $refuseAction = Action::new('refuse', 'Refuser')
        ->linkToCrudAction('refuserUser')
        ->setHtmlAttributes(['data-entity-id' => 'id']);
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Action::INDEX, $approveAction)
            ->add(Action::INDEX, $refuseAction)
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
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel('Ajouter un utilisateur')
                    ->setIcon('fa fa-plus');
            })
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
    public function approveUser(): RedirectResponse
{
    $user = $this->getUserFromRequest();
    if ($user) {
      // dd($user);
        $referenceCode = $this->generateReferenceCode($user);
        
        $this->sendEmail(
            $user,
            'Votre demande a été approuvée',
            "Félicitations, votre demande a été approuvée ! Voici votre code de référence : $referenceCode"
        );
    }

    return $this->redirect($this->generateUrl('admin_dashboard'));
}
    public function refuserUser(): RedirectResponse
    {
        $user = $this->getUserFromRequest();
        if ($user) {
            $user->setIsVerified(true);
            $this->entityManager->flush();
           // dd("tonga ato");
          // dd($user);
           $this->sendEmail(
           $user, 
           'Votre demande a été refuse',
           "Votre demande Avis prealable a été refuse !"
       );
        }
        return $this->redirect($this->generateUrl('admin'));
       // 
         // return User::class;
    }
    /*
    private function getUserFromRequest(): ?User
    {
        
        $id = $this->requestStack->getCurrentRequest()->query->get('entityId');
        return $this->entityManager->getRepository(User::class)->find($id);
    return $this->entityManager->getRepository(User::class)->find($id);
    }
    */
    private function getUserFromRequest(): ?User
    {
        // Récupère l'ID de la demande depuis la requête
        $maDemandeId = $this->requestStack->getCurrentRequest()->query->get('entityId');
        
        // Récupère l'entité MaDemande associée
        $maDemande = $this->entityManager->getRepository(MaDemande::class)->find($maDemandeId);
    //dd($maDemande);
        // Si MaDemande existe et a un utilisateur associé, retourne cet utilisateur
        if ($maDemande && $maDemande->getIdUsers()) {
            return $maDemande->getIdUsers();
        }
    
        // Si aucun utilisateur n'est trouvé, retourne null
        return null;
    }
    
    private function sendEmail(User $user, string $subject, string $message)
{
    try {
    
        $transport = new EsmtpTransport('smtp.gmail.com', 465, 'ssl');
        $transport->setUsername('hobitianaandriamanantena@gmail.com');
        $transport->setPassword('dqqc wzmh kivm john');

        $mailer = new Mailer($transport);

        $email = (new TemplatedEmail())
            ->from('hobitianaandriamanantena@gmail.com')
            ->to($user->getEmail())
            ->subject($subject)
            ->text($message);
                     $this->bodyRenderer->render($email);

                     $mailer->send($email);

            } catch (\Exception $e) {
                // Enregistrer l’erreur dans les logs de Symfony
                $this->addFlash('danger', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
            }
        }
        private function generateReferenceCode(User $user): string
{
    // Exemple : concaténation de l'ID, de l'email et d'un timestamp, puis hashage
         $data = $user->getId() . $user->getEmail() . time();
        // dd($data);
          return substr(hash('sha256', $data), 0, 10); // Code unique de 10 caractères
}
}
