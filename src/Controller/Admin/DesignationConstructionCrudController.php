<?php

namespace App\Controller\Admin;

use App\Entity\DesignationConstruction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DesignationConstructionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DesignationConstruction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Désignations de Construction')
        ->setPageTitle(Crud::PAGE_NEW, 'Créer une Désignation de Construction')
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une Désignation de Construction');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('designation', 'Type de construction'), // Remplace "Designation" par "Type de construction"
        ];
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
                    ->setLabel('Ajouter une désignation')
                    ->setIcon('fa fa-plus');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel('Modifier une désignation')
                    ->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel('Supprimer une désignation')
                    ->setIcon('fa fa-trash');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setLabel('Voir une désignation')
                    ->setIcon('fa fa-eye');
            });
    }
}
