<?php

namespace App\Controller\Admin;

use App\Entity\DescriptionCamping;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DescriptionCampingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DescriptionCamping::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('designation', 'Description de camping'), // Remplace "Designation" par "Description de Camping"
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel('Ajouter une description') // Updated label to match the entity context
                    ->setIcon('fa fa-plus'); 
            });
    }
}
