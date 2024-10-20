<?php

namespace App\Tests\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        // Crée une instance de client pour faire des requêtes HTTP
        $client = static::createClient();

        // Simule la réponse de l'entité LivreRepository
        $mockLivreRepository = $this->createMock(LivreRepository::class);

        // Configure le mock pour renvoyer une liste de livres (vides pour ce test)
        $mockLivreRepository->method('findAll')->willReturn([]);

        // Enregistre le mock dans le conteneur de services
        $client->getContainer()->set(LivreRepository::class, $mockLivreRepository);

        // Effectue une requête GET vers la route de l'index
        $client->request('GET', '/');

        // Vérifie que la réponse est une redirection ou un code HTTP 200
        $this->assertResponseIsSuccessful();

        // Vérifie que le template rendu est le bon
        $this->assertSelectorTextContains('h1', 'Page d\'accueil de la librairie'); // Assure-toi que ce texte est correct

    }
}
