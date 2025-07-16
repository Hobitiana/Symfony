<?php

namespace App\Controller\Admin;

use App\Entity\ResultatDemande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResultatDemandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ResultatDemande::class;
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
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('reference', 'La reference'),
            AssociationField::new('user', 'user')
                ->setCrudController(ResultatDemandeCrudController::class),
            // Ajouter d'autres champs si nécessaire
        ];
    }
}
