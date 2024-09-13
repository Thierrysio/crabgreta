<?php

namespace App\Controller;
use App\Entity\Borne;
use App\Entity\TypeBorne;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


       
}
}