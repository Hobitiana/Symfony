<?php

namespace App\Controller\Admin;

use App\Entity\DesignationTypeModel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DesignationTypeModelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DesignationTypeModel::class;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         IdField::new('id', 'ID'),
    //         TextField::new('title', 'Titre'), // Updated label
    //         TextEditorField::new('description', 'Description'), // Updated label
    //     ];
    // }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel('Ajouter une désignation') // Updated label to fit entity context
                    ->setIcon('fa fa-plus'); 
            });
    }
}
