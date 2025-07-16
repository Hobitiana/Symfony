<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AproposavisprealableController extends AbstractController
{
    #[Route('/aproposavisprealable', name: 'app_aproposavisprealable')]
    public function index(): Response
    {
        return $this->render('aproposavisprealable/index.html.twig');
    }
}
