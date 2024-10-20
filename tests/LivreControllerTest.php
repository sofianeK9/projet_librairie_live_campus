<?php

namespace App\Tests\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Form\LivreType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactoryInterface;

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LivreControllerTest extends WebTestCase
{
    public function testPerformance(): void
    {
        $client = static::createClient();
        $start = microtime(true);
    
        $client->request('GET', '/livre/liste');
    
        $end = microtime(true);
        $duration = $end - $start;
    
        // Vérifie que la page se charge en moins de 2 secondes
        $this->assertLessThan(2, $duration);
    }
    
}
