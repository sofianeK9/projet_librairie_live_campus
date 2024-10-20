<?php

namespace App\Tests\Entity;

use App\Entity\Auteur; 
use PHPUnit\Framework\TestCase;

class AuteurTest extends TestCase
{
    public function testAuteurEntity(): void
    {

        // test unitaire d'entité livre pour s'assurer que que chaque méthode de la
        // classe fonctionne correctement en isolation
        $auteur = new Auteur();
        $auteur->setNom('bob');
        $auteur->setPrenom('dylan');

        // Assertions, elles vérifient que la méthode retourne bien la meme valeur

        $this->assertEquals('bob', $auteur->getNom());
        $this->assertEquals('dylan', $auteur->getPrenom());
    }
}
