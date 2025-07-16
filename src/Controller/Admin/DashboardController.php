<?php

namespace App\Controller\Admin;

use App\Entity\Commune;
use App\Entity\DesignationCamping;
use App\Entity\MaDemande;
use App\Entity\DesignationConstruction;
use App\Entity\DesignationHebergement;
use App\Entity\DesignationRestaurant;
use App\Entity\District;
use App\Entity\Fokotany;
use App\Entity\QuestionCamping;
use App\Entity\QuestionChoixCamping;
use App\Entity\QuestionChoixHebergement;
use App\Entity\QuestionChoixRestaurant;
use App\Entity\QuestionHebergement;
use App\Entity\QuestionRestaurant;
use App\Entity\Region;
use App\Entity\ResultatDemande;
use App\Entity\GroupeActivite1;
use App\Entity\Activite1;
use App\Entity\Nationalite;
use App\Entity\DesignationTypeModel;
use App\Entity\User;
use App\Entity\ResponsableDemande;
use App\Service\StatistiqueUserService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin')]
// #[IsGranted('ROLE_SUPER_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin_dashboard')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        } elseif ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($adminUrlGenerator->setController(ResponsableDemandeCrudController::class)->generateUrl());
        } elseif ($this->isGranted('ROLE_DAT')) {
            return $this->redirect($adminUrlGenerator->setController(ResultatDemandeCrudController::class)->generateUrl());
        } elseif ($this->isGranted('ROLE_EDBM')) {
            return $this->redirect($adminUrlGenerator->setController(ResultatDemandeCrudController::class)->generateUrl());
        } 
         else {
            return $this->redirect($adminUrlGenerator->setController(ResultatDemandeCrudController::class)->generateUrl());
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E-Dematerialisation');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::section('Accueil');
        yield MenuItem::linkToUrl('Accueil', 'fas fa-home', $this->generateUrl('dashboard'));
    
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::section('Gestion des Utilisateurs');
            yield MenuItem::linkToCrud("Utilisateur", 'fas fa-list', User::class);

            yield MenuItem::section('Gestion de la Demande');
            yield MenuItem::linkToCrud("Nationalité", 'fas fa-list', Nationalite::class);
            yield MenuItem::linkToCrud("Groupe Activité", 'fas fa-list', GroupeActivite1::class);
            yield MenuItem::linkToCrud("Activité", 'fas fa-list', Activite1::class);

            yield MenuItem::section('Gestion des affichages');
            yield MenuItem::subMenu('Désignations', 'fas fa-tags')->setSubItems([
                MenuItem::linkToCrud("Construction", 'fas fa-hammer', DesignationConstruction::class),
                MenuItem::linkToCrud("Hébergement", 'fas fa-bed', DesignationHebergement::class),
                MenuItem::linkToCrud("Restauration", 'fas fa-utensils', DesignationRestaurant::class),
                MenuItem::linkToCrud("Camping", 'fas fa-campground', DesignationCamping::class),
                MenuItem::linkToCrud("Choix Hébergement", 'fas fa-check', QuestionChoixHebergement::class),
                MenuItem::linkToCrud("Choix Restauration", 'fas fa-check', QuestionChoixRestaurant::class),
                MenuItem::linkToCrud("Choix Camping", 'fas fa-check', QuestionChoixCamping::class),
                MenuItem::linkToCrud("Type de Demande", 'fas fa-file-alt', DesignationTypeModel::class),
            ]);
    
            yield MenuItem::subMenu("Lieu d'implantation", 'fas fa-tags')->setSubItems([
                MenuItem::linkToCrud("Région", 'fas fa-map-marked', Region::class),
                MenuItem::linkToCrud("Commune", 'fas fa-city', Commune::class),
                MenuItem::linkToCrud("District", 'fas fa-map', District::class),
                MenuItem::linkToCrud("Fokotany", 'fas fa-street-view', Fokotany::class),
            ]);
    
            yield MenuItem::subMenu('Questions', 'fas fa-tags')->setSubItems([
                MenuItem::linkToCrud("Question Hébergement", 'fas fa-question', QuestionHebergement::class),
                MenuItem::linkToCrud("Question Restauration", 'fas fa-question', QuestionRestaurant::class),
                MenuItem::linkToCrud("Question Camping", 'fas fa-question', QuestionCamping::class),
            ]);

            yield MenuItem::linkToRoute('Exporter les utilisateurs en CSV', 'fa fa-file-csv', 'admin_export_csv');
            yield MenuItem::linkToCrud('Ma Demande', 'fas fa-list', MaDemande::class);
            yield MenuItem::linkToCrud('Verification Demande', 'fas fa-list', ResponsableDemande::class);
        }
        if ($this->isGranted('ROLE_DRTM') && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::section('Bienvenue DRTM');
            yield MenuItem::linkToCrud('Liste Demande', 'fas fa-list', ResponsableDemande::class);
        }
        if ($this->isGranted('ROLE_EDBM') && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::section('Bienvenue EDBM');
            yield MenuItem::linkToCrud('Liste Demande', 'fas fa-list', ResponsableDemande::class);
        }
        if ($this->isGranted('ROLE_DAT') && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::section('Bienvenue DAT');
            yield MenuItem::linkToCrud('Liste Demande', 'fas fa-list', ResponsableDemande::class);
        }

      
    }
}
