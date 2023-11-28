<?php

namespace App\Controller;

use Survos\BootstrapBundle\Service\MenuService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(MenuService $menuService): Response
    {
        return $this->render('landing/index.html.twig', [
            'users' => $menuService->getUsersToImpersonate()
        ]);
    }
}
