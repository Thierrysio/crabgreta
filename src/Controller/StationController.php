<?php

namespace App\Controller;

use App\Entity\Borne;
use App\Entity\Station;
use App\Entity\Maintenance;
use App\Entity\TypeBorne;
use App\Form\StationType;
use App\Repository\BorneRepository;
use App\Repository\StationRepository;
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

   
    // Définition de la route pour l'URL '/station/voirunecollection' avec le nom 'app_station_voir_une_collection'
#[Route('/station/voirunecollection', name: 'app_station_voir_une_collection')]
public function voirUneCollection(EntityManagerInterface $entityManager): Response
{
    // Création d'un nouvel objet Borne
    $borne = new Borne();
    // Définition de la date de la dernière révision à la date actuelle
    $borne->setDateDerniereRevision(new \DateTime());
    // Définition de l'indice du compteur d'unités à 100
    $borne->setIndiceCompteurUnites(100);
    // Persistance de l'objet Borne pour l'enregistrer en base de données
    $entityManager->persist($borne);

    // Création d'un deuxième objet Borne
    $borne2 = new Borne();
    // Définition de la date de la dernière révision à la date actuelle
    $borne2->setDateDerniereRevision(new \DateTime());
    // Définition de l'indice du compteur d'unités à 100
    $borne2->setIndiceCompteurUnites(100);
    // Persistance du deuxième objet Borne
    $entityManager->persist($borne2);

    // Création d'un nouvel objet Station
    $uneStation = new Station();
    // Définition du libellé de l'emplacement de la station
    $uneStation->setLibelleEmplacement('station 04');
    // Association des bornes créées à la station
    $uneStation->addLesBorne($borne);
    $uneStation->addLesBorne($borne2);

    // Persistance de l'objet Station
    $entityManager->persist($uneStation);
    // Exécution des opérations de persistance en base de données
    $entityManager->flush();

    // Rendu de la vue 'voirunecollection.html.twig' en passant la station créée
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

        // Définition de la route pour l'URL '/station/voirunecollection' avec le nom 'app_station_voir_une_collection'
#[Route('/station/voirunecollectionavectype', name: 'app_station_voir_une_collection_avec_type')]
public function voirUneCollectionAvecType(EntityManagerInterface $entityManager): Response
{
    $typeBorne = new TypeBorne();
    $typeBorne->setDureeRevision(50);
    $typeBorne->setNbJoursEntreRevisions(20);
    $typeBorne->setNbUnitesEntreRevisions(60);
    $entityManager->persist( $typeBorne);
    // Création d'un nouvel objet Borne
    $borne = new Borne();
    // Définition de la date de la dernière révision à la date actuelle
    $borne->setDateDerniereRevision(new \DateTime());
    // Définition de l'indice du compteur d'unités à 100
    $borne->setIndiceCompteurUnites(100);
    // Persistance de l'objet Borne pour l'enregistrer en base de données
    $borne->setLeTypeBorne($typeBorne);
    $entityManager->persist($borne);

    // Création d'un deuxième objet Borne
    $borne2 = new Borne();
    // Définition de la date de la dernière révision à la date actuelle
    $borne2->setDateDerniereRevision(new \DateTime());
    // Définition de l'indice du compteur d'unités à 100
    $borne2->setIndiceCompteurUnites(100);
    // Persistance du deuxième objet Borne
    $borne2->setLeTypeBorne($typeBorne);
    $entityManager->persist($borne2);

    // Création d'un nouvel objet Station
    $uneStation = new Station();
    // Définition du libellé de l'emplacement de la station
    $uneStation->setLibelleEmplacement('station 04');
    // Association des bornes créées à la station
    $uneStation->addLesBorne($borne);
    $uneStation->addLesBorne($borne2);

    // Persistance de l'objet Station
    $entityManager->persist($uneStation);
    // Exécution des opérations de persistance en base de données
    $entityManager->flush();

    // Rendu de la vue 'voirunecollection.html.twig' en passant la station créée
    return $this->render('station/voirunecollectionavectype.html.twig', [
        'maStation' => $uneStation,
    ]);
}
// Définition de la route associée à l'URL /station/voirunestation/{id}
// {id} représente un paramètre dynamique capturé dans l'URL.
// 'name' permet de donner un nom unique à la route pour faciliter sa réutilisation.
#[Route('/station/voirunestation/{id}', name: 'app_station_voir_une_station')]
public function voirUneStation(Station $uneStation): Response
{
    // Cette méthode reçoit un objet de type Station, probablement via le paramètre {id}
    // qui est transformé en objet Station par Symfony (grâce à un param converter).
    
    // La méthode renvoie une vue (template Twig) située dans station/voirunestation.html.twig
    // et passe l'objet $uneStation à la vue en le nommant 'maStation' dans le contexte du template.
    return $this->render('station/voirunestation.html.twig', [
        'maStation' => $uneStation,
    ]);
}

#[Route('/station/voirtouteslesstations', name: 'app_voir_toutes_les_stations')]
public function voirToutesLesStations(StationRepository $stationRepository): Response
{
$lesStations = $stationRepository->findAll();

return $this->render('station/voirtouteslesstations.html.twig', [
    'mesStations' => $lesStations,
]);

}

#[Route('/station/voirlesbornesavecrevision/{id}', name: 'app_station_voir_les_bornes_avec_revision')]
public function voirLesBornesAvecRevision(Station $uneStation,BorneRepository $borneRepository): Response
{
    $collectionBorneRepository = $borneRepository->getLibelleEmplacementEtDureeRevisionParStation($uneStation);
    dd($collectionBorneRepository);
    return $this->render('station/voirunestation.html.twig', [
        'maStation' => $uneStation,
    ]);
}
}
