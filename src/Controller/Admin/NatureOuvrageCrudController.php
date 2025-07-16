<?php
namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\NatureOuvrage;
use Doctrine\ORM\EntityManagerInterface;

class NatureOuvrageCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return NatureOuvrage::class;
    }

    // Your CRUD methods...
}
