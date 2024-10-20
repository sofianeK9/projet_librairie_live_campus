<?php

namespace App\Tests\Entity;

use App\Entity\Livre;
use App\Entity\Auteur; 
use PHPUnit\Framework\TestCase;

class LivreTest extends TestCase
{
    public function testLivreEntity(): void
    {

        // test unitaire d'entité livre pour s'assurer que que chaque méthode de la
        // classe fonctionne correctement en isolation

        $auteur = new Auteur();
        $auteur->setNom('bob');
        $auteur->setPrenom('dylan');

        $livre = new Livre();
        $livre->setTitre('Test Titre');
        $livre->setAnneeEdition(2023);
        $livre->setNombrePages(300);
        $livre->setCodeIsbn('1254852545');
        $livre->setAuteur($auteur);
        $livre->setSlug('livre');
        $livre->setResume('resume de livre');
        $livre->setDisponible(true);


        // Assertions, elles vérifient que la méthode retourne bien la meme valeur

        $this->assertEquals('Test Titre', $livre->getTitre());
        $this->assertEquals(2023, $livre->getAnneeEdition());
        $this->assertEquals(300, $livre->getNombrePages());
        $this->assertEquals('1254852545', $livre->getCodeIsbn());
        $this->assertEquals('livre', $livre->getSlug());
        $this->assertEquals('resume de livre', $livre->getResume());
    }
}
