<?php

namespace App\Tests;

use App\Entity\Borne;
use App\Entity\TypeBorne;
use PHPUnit\Framework\TestCase;

class BorneTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
    public function testGetTypeBorneId()
    {
        // Création d'un mock pour la classe TypeBorne
        $typeBorneMock = $this->createMock(TypeBorne::class);

        // On configure le mock pour retourner un ID particulier quand getId() est appelé
        $typeBorneMock->method('getId')
                      ->willReturn(123);

        // Création de l'objet Borne à tester
        $borne = new Borne();

        // On injecte le mock de TypeBorne dans la Borne
        $borne->setLeTypeBorne($typeBorneMock);

        // Vérification que la méthode getTypeBorneId() retourne bien l'ID du mock
        $this->assertEquals(123, $borne->getTypeBorneId());
    }

    public function testGetTypeBorneIdReturnsNullIfNoTypeBorne()
    {
        // Création de l'objet Borne à tester sans TypeBorne
        $borne = new Borne();

        // Vérification que la méthode retourne null quand aucun TypeBorne n'est défini
        $this->assertNull($borne->getTypeBorneId());
    }

}
