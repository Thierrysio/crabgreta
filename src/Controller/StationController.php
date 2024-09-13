<?php

namespace App\Controller;

use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StationController extends AbstractController
{
    #[Route('/station', name: 'app_station')]
    public function index(): Response
    {
        return $this->render('station/index.html.twig', [
            'controller_name' => 'StationController',
        ]);
    }

    #[Route('/station/creer', name: 'app_station_creer')]
    public function creer(EntityManagerInterface $entityManager): Response
    {
        $station = new Station();
        $station->setLibelleEmplacement('station 01');

        $entityManager->persist($station);
        $entityManager->flush();

        return new Response('la station dont le nom est : '. $station->getLibelleEmplacement() .' a été créée avec succès');





    }
}
