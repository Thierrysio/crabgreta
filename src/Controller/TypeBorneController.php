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

    if($untypeborne->getLesItems())
    {
        return $this->render('type_borne/voiruntypeborneavecbornes.html.twig', [
            'unTypeBorne' => $untypeborne,
        ]);
    }
    else
    {
        return $this->render('type_borne/voiruntypebornesansborne.html.twig', [
            'unTypeBorne' => $untypeborne,
        ]);
    }

    //je dois verifier l'existence d'une collection de bornes
    // si ok j'utilise le render deja créé
    // sinon je cree un render qui generera le tyborne mais indiquera la non exisrence de la collection
    

}
}
