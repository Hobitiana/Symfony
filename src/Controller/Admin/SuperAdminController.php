<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Attribute\IsGranted as AttributeIsGranted;

class SuperAdminController extends AbstractController
{
   
    #[Route('/superadmin/dashboard', name: 'superadmin_dashboard')]
    public function superAdminDashboard(): Response
    {
        return $this->render('admin/super_admin_dashboard.html.twig');
    }
   
}
