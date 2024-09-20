<?php

namespace App\Controller;

use App\Entity\Borne;
use App\Entity\Station;
use App\Entity\Maintenance;
use App\Form\StationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    // Définition de la route pour accéder à cette action du contrôleur
    #[Route('/station/creerform', name: 'app_station_creer_form')]
    public function creerform(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Station
        $station = new Station();

        // Création du formulaire en associant l'entité Station
        $form = $this->createForm(StationType::class, $station);

        // Traitement de la requête HTTP
        // Cette ligne permet au formulaire de gérer les données soumises par l'utilisateur
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            // Cette étape est optionnelle car l'entité $station est déjà mise à jour
            $station = $form->getData();

            // Préparation de l'entité pour la sauvegarde en base de données
            $entityManager->persist($station);

            // Exécution de la requête pour sauvegarder l'entité
            $entityManager->flush();

            // Redirection vers une autre page après le succès de l'opération
            // Assurez-vous que la route 'task_success' existe
            return $this->redirectToRoute('task_success');
        }

        // Affichage du formulaire dans la vue Twig
        return $this->render('station/new.html.twig', [
            // Transmission de la vue du formulaire à la template Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/station/creeravecborne', name: 'app_station_creeravecborne')]
    public function creeravecborne(EntityManagerInterface $entityManager): Response
    {
        $maintenance = new Maintenance();
        $entityManager->persist($maintenance);

        $borne = new Borne();
        $borne->setDateDerniereRevision(new \DateTime());
        $borne->setIndiceCompteurUnites(100);

        $borne2 = new Borne();
        $borne2->setDateDerniereRevision(new \DateTime());
        $borne2->setIndiceCompteurUnites(50);
        
        $entityManager->persist($borne);
        $entityManager->persist($borne2);

        $station = new Station();
        $station->setLibelleEmplacement('station 02');

        $station->addLesBorne($borne);
        $station->addLesBorne($borne2);

        $station->setLaMaintenance($maintenance);


        $entityManager->persist($station);
        $entityManager->flush();

        return $this->render('station/stationBorne.html.twig', [
            'laStation' => $station,
        ]);
    }

    #[Route('/station/voirunecollection', name: 'app_station_voir_une_collection')]
    public function voirUneCollection(EntityManagerInterface $entityManager): Response
   
    {
        $borne = new Borne();
        $borne->setDateDerniereRevision(new \DateTime());
        $borne->setIndiceCompteurUnites(100);
        $entityManager->persist($borne);

        $borne2 = new Borne();
        $borne2->setDateDerniereRevision(new \DateTime());
        $borne2->setIndiceCompteurUnites(100);
        $entityManager->persist($borne2);

        $uneStation = new Station();

        $uneStation->setLibelleEmplacement('station 04');
        $uneStation->addLesBorne($borne);
        $uneStation->addLesBorne($borne2);

        $entityManager->persist($uneStation);
        $entityManager->flush();

        return $this->render('station/voirunecollection.html.twig', [
            'maStation' => $uneStation,
        ]);
    }
    #[Route('/station/voirunobjet', name: 'app_station_voir_un_objet')]
    public function voirUnObjet(EntityManagerInterface $entityManager): Response
     {
        
        $uneStation = new Station();

        $uneStation->setLibelleEmplacement('station 04');

        $entityManager->persist($uneStation);
        $entityManager->flush();

        return $this->render('station/voirunobjet.html.twig', [
            'maStation' => $uneStation,
        ]);
    }
}
