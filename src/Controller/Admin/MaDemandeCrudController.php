<?php

namespace App\Controller\Admin;

use App\Entity\MaDemande;
use App\Entity\CasDeLocation;
use App\Entity\NatureOuvrage;
use App\Repository\NatureOuvrageRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class MaDemandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaDemande::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Tous les demandes')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer demande')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier demande');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel('Créer et ajouter une autre')->setIcon('fa fa-plus');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Créer')->setIcon('fa fa-check');
            })
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Modifier demande')->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Supprimer demande')->setIcon('fa fa-trash');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir demande')->setIcon('fa fa-eye');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Informations générales'),
            IdField::new('id')->onlyOnDetail(),
            DateField::new('dateActuel', 'Date Actuel')
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->onlyOnForms() // Désactiver uniquement dans les formulaires
                ->setFormTypeOption('disabled', $pageName === Crud::PAGE_EDIT),
            TextField::new('maTypeDeDemande', 'Type De Demande')
                ->onlyOnForms()
                ->setFormTypeOption('disabled', $pageName === Crud::PAGE_EDIT),
          
            ChoiceField::new('status', 'Status')
                ->setChoices([
                    'En attente' => 'en_attente',
                    'En cours' => 'en_cours',
                    'Approuvé' => 'approuve',
                    'Rejeté' => 'rejete',
                    'Complété' => 'complete',
                    'Annulé' => 'annule',
                ])
                ->renderExpanded(true)
                ->setRequired(true),

            FormField::addTab('Détails de la demande'),
            AssociationField::new('idUsers', 'Utilisateur')
                ->onlyOnForms()
                ->setFormTypeOption('disabled', true),
        ];
    }
}
