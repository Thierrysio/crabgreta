<?php

namespace App\Controller;

use App\Entity\TypeBorne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeBorneController extends AbstractController
{
    #[Route('/type/borne', name: 'app_type_borne')]
    public function index(): Response
    {
        return $this->render('type_borne/index.html.twig', [
            'controller_name' => 'TypeBorneController',
        ]);
    }

    #[Route('/type/borne/voiruntypeborne/{id}', name: 'app_type_borne_voir_un_type_borne')]
    public function voirUnTypeBorne(TypeBorne $untypeborne): Response
{
    
    {
        return $this->render('type_borne/voiruntypeborne.html.twig', [
            'unTypeBorne' => $untypeborne,
        ]);
    }

}
}
