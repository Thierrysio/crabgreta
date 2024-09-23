<?php

namespace App\Controller;
use App\Entity\Borne;
use App\Entity\TypeBorne;
use App\Form\BorneType;
use App\Repository\BorneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BorneController extends AbstractController
{
    #[Route('/borne', name: 'app_borne')]
    public function index(): Response
    {
        return $this->render('borne/index.html.twig', [
            'controller_name' => 'BorneController',
        ]);
    }

    #[Route('/borne/creerBorne', name: 'app_borne_creer_Borne')]
    public function creerBorne(EntityManagerInterface $entityManager): Response
    {

        $borne = new Borne();
        $borne->setDateDerniereRevision(new \DateTime());
        $borne->setIndiceCompteurUnites(100);

        $entityManager->persist($borne);

        $entityManager->flush();

        return new Response('aaa');      
}

    #[Route('/borne/creerBorneTypeBorne', name: 'app_borne_creerBorneTypeBorne')]
    public function creerBorneTypeBorne(EntityManagerInterface $entityManager): Response
    {
        $typeBorne = new TypeBorne();
        $typeBorne->setDureeRevision(60);
        $typeBorne->setNbJoursEntreRevisions(120);
        $typeBorne->setNbUnitesEntreRevisions(90);

        $entityManager->persist($typeBorne);

        $borne = new Borne();
        $borne->setDateDerniereRevision(new \DateTime());
        $borne->setIndiceCompteurUnites(100);
        $borne->setLeTypeBorne($typeBorne);

        $entityManager->persist($borne);

        $entityManager->flush();

        return new Response('aaa');      
}
 // Définition de la route pour accéder à cette action du contrôleur
 #[Route('/borne/creerform', name: 'app_borne_creer_form')]
 public function creerform(Request $request, EntityManagerInterface $entityManager): Response
 {
     // Création d'une nouvelle instance de l'entité Station
     $borne = new Borne();

     // Création du formulaire en associant l'entité Station
     $form = $this->createForm(BorneType::class, $borne);

     // Traitement de la requête HTTP
     // Cette ligne permet au formulaire de gérer les données soumises par l'utilisateur
     $form->handleRequest($request);

     // Vérification si le formulaire a été soumis et si les données sont valides
     if ($form->isSubmitted() && $form->isValid()) {
         // Récupération des données du formulaire
         // Cette étape est optionnelle car l'entité $station est déjà mise à jour
         $borne = $form->getData();

         // Préparation de l'entité pour la sauvegarde en base de données
         $entityManager->persist($borne);

         // Exécution de la requête pour sauvegarder l'entité
         $entityManager->flush();

         // Redirection vers une autre page après le succès de l'opération
         // Assurez-vous que la route 'task_success' existe
         return $this->redirectToRoute('task_success');
     }

     // Affichage du formulaire dans la vue Twig
     return $this->render('borne/new.html.twig', [
         // Transmission de la vue du formulaire à la template Twig
         'form' => $form->createView(),
     ]);
 }
 #[Route('/borne/voiruneborne/{id}', name: 'app_borne_voir_une_borne')]
 public function voirUneBorne(Borne $uneBorne): Response
 {
    return $this->render('borne/voiruneborne.html.twig', [
        'maBorne' => $uneBorne,
    ]);
 }
 #[Route('/borne/voirtouteslesbornes', name: 'app_voir_toutes_les_bornes')]
public function voirToutesLesStations(BorneRepository $borneRepository): Response
{
$lesBornes = $borneRepository->findAll();

return $this->render('borne/voirtouteslesbornes.html.twig', [
    'mesBornes' => $lesBornes,
]);

}
}