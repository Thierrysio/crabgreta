<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(): Response
    {
        return $this->render('maintenance/index.html.twig', [
            'controller_name' => 'MaintenanceController',
        ]);
    }
    #[Route('/maintenance/creer', name: 'app_maintenance_creer')]
    public function creer(): Response
    {
        return $this->render('maintenance/creer.html.twig', [
            'controller_name' => 'MaintenanceController',
        ]);
    }
}
