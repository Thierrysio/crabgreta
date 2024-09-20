<?php

namespace App\Controller;

use App\Entity\Maintenance;
use App\Entity\Station;
use App\Entity\Visite;
use Doctrine\ORM\EntityManagerInterface;
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
    public function creer(EntityManagerInterface $entityManager): Response
    {
        $station = new Station();
        $station->setLibelleEmplacement('station 01');
        $entityManager->persist($station);

        $visite1 = new Visite();
        $visite1->setDureeTotale(56);
        $visite1->setEtat('encours');
        $visite1->setLaStation($station);
        $entityManager->persist($visite1);

        $visite2 = new Visite();
        $visite2->setDureeTotale(65);
        $visite2->setEtat('terminé');
        $visite2->setLaStation($station);
        $entityManager->persist($visite2);

        $maintenance = new Maintenance();
        $maintenance->addLesVisite($visite1);
        $maintenance->addLesVisite($visite2);

        $entityManager->persist($maintenance);

        $entityManager->flush();
        



        return $this->render('maintenance/creer.html.twig', [
            'laMaintenance' => $maintenance,
        ]);
    }
}
