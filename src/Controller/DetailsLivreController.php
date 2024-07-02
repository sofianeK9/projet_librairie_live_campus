<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Util\Slugger;

class DetailsLivreController extends AbstractController
{
    #[Route('/details/livre/{titre}-{id}', name: 'livre.details', requirements: [
        'titre' => '[a-z0-9-]+',
        'id' => '\d+'
    ])]
    public function index(Request $request, LivreRepository $LivreRepository, string $titre, int $id): Response
    {
        $livre = $LivreRepository->find($id);

        if (!$livre) {
            throw $this->createNotFoundException('Livre non trouvé !');
        }
        $slug = Slugger::slugify($livre->getTitre());

        if ($titre !== $slug) {
            return $this->redirectToRoute('livre.details', 
            [
            'titre' => $slug, 
            'id' => $livre->getId()], 
            301);
        }

        return $this->render('details_livre/index.html.twig', [
            'livre' => $livre,
        ]);
    }
}
