<?php

namespace App\Controller;

use App\Entity\Borne;
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

        return new Response('la station dont le nom est : '. $station->getLibelleEmplacement() .' a été créée avecsucces');

    }

    #[Route('/station/creeravecborne', name: 'app_station_creeravecborne')]
    public function creeravecborne(EntityManagerInterface $entityManager): Response
    {
        $borne = new Borne();
        $borne->setDateDerniereRevision(new \DateTime());
        $borne->setIndiceCompteurUnites(100);

        $borne2 = new Borne();
        $borne2->setDateDerniereRevision(new \DateTime());
        $borne2->setIndiceCompteurUnites(50);
        
        $entityManager->persist($borne);
        $entityManager->persist($borne2);

        $station = new Station();
        $station->setLibelleEmplacement('station 01');
        $station->addLesBorne($borne);
        $station->addLesBorne($borne2);


        $entityManager->persist($station);
        $entityManager->flush();

        return new Response('la station dont le nom est : '. $station->getLibelleEmplacement() .' a été créée avecsucces');

    }
}
