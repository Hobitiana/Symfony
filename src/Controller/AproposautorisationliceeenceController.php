<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AproposautorisationliceeenceController extends AbstractController
{
    #[Route('/aproposautorisationliceeence', name: 'app_aproposautorisationliceeence')]
    public function index(): Response
    {
        return $this->render('aproposautorisationliceeence/index.html.twig');
    }
}
