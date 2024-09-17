<?php

namespace App\Tests;
use App\Entity\Borne;
use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

class VisiteTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
    public function testGetTotalIndiceCompteurUnitesWithRealVisite()
    {
        // Création de l'objet Visite à tester (pas de mock cette fois-ci)
        $visite = new Visite();

        // Création de deux mocks pour la classe Borne
        $borneMock1 = $this->createMock(Borne::class);
        $borneMock2 = $this->createMock(Borne::class);

        // On configure les mocks pour retourner des valeurs spécifiques pour getIndiceCompteurUnites()
        $borneMock1->method('getIndiceCompteurUnites')->willReturn(100);
        $borneMock2->method('getIndiceCompteurUnites')->willReturn(200);

        // On ajoute les bornes à la visite
        $visite->addLesBorne($borneMock1);
        $visite->addLesBorne($borneMock2);

        // On appelle la méthode à tester
        $total = $visite->getTotalIndiceCompteurUnites();

        // Vérification que le total est la somme des indices des bornes (100 + 200)
        $this->assertEquals(300, $total);
    }

    public function testGetTotalIndiceCompteurUnitesNew()
    {
        // Création de deux mocks pour la classe Borne
        $borneMock1 = $this->createMock(Borne::class);
        $borneMock2 = $this->createMock(Borne::class);

        // On configure le mock pour retourner des valeurs spécifiques pour getIndiceCompteurUnites()
        $borneMock1->method('getIndiceCompteurUnites')->willReturn(100);
        $borneMock2->method('getIndiceCompteurUnites')->willReturn(200);

        // Création de l'objet Visite à tester
        $visite = $this->getMockBuilder(Visite::class)
                       ->onlyMethods(['getLesBornes']) // On se moque uniquement de la méthode getLesBornes()
                       ->getMock();

        // On configure le mock pour que getLesBornes() retourne un tableau de bornes
        $visite->method('getLesBornes')->willReturn([$borneMock1, $borneMock2]);

        // On appelle la méthode à tester
        $total = $visite->getTotalIndiceCompteurUnites();

        // Vérification que le total est la somme des indices des bornes (100 + 200)
        $this->assertEquals(300, $total);
    }
}
