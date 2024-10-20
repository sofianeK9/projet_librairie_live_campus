<?php

namespace App\Tests\Entity;

use App\Entity\User; 
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserEntity(): void
    {

        // test unitaire d'entité livre pour s'assurer que que chaque méthode de la
        // classe fonctionne correctement en isolation
        $user = new User();
        $user->setEmail('bob@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('123');
        $user->setConsentement(true);
       



        // Assertions, elles vérifient que la méthode retourne bien la meme valeur

        $this->assertEquals('bob@example.com', $user->getEmail());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
        $this->assertEquals('123', $user->getPassword());
        $this->assertEquals(true, $user->isConsentement());
    }
}
