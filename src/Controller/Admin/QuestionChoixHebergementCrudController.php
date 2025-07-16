<?php

namespace App\Controller\Admin;

use App\Entity\QuestionChoixHebergement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuestionChoixHebergementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuestionChoixHebergement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Questions de Choix de Hébergement')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une Question de Choix de Hébergement')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une Question de Choix de Hébergement');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
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
                    ->setLabel('Ajouter une question')
                    ->setIcon('fa fa-plus');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel('Modifier une question')
                    ->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel('Supprimer une question')
                    ->setIcon('fa fa-trash');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setLabel('Voir une question')
                    ->setIcon('fa fa-eye');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Questions', 'Question de choix de hébergement'), // Remplace "Designation" par "Type de Hébergement"
        ];
    }
}
