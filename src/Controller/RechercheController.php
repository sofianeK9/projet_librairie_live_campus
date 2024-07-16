<?php

namespace App\Controller;

use App\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        $results = [];
        $keyword = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $keyword = $form->get('keyword')->getData();
            $results = $entityManager->getRepository(Livre::class)->recherche($keyword);
        }

        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
            'keyword' => $keyword,
        ]);
    }
}

