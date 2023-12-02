<?php

namespace App\Controller;

use Survos\BootstrapBundle\Service\MenuService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function indexNoLocale(MenuService $menuService): Response
    {
        return $this->redirectToRoute('app_homepage_with_locale', ['_locale' => 'en']);
    }

    #[Route('/{_locale}', name: 'app_homepage_with_locale')]
    public function index(MenuService $menuService): Response
    {
        return $this->render('landing/index.html.twig', [
            'users' => $menuService->getUsersToImpersonate()
        ]);
    }

}
