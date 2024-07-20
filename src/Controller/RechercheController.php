<?php

namespace App\Controller;

use App\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livre;
use App\Repository\LivreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator, LivreRepository $livreRepository): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        $pagination = null;
        $keyword = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $keyword = $form->get('keyword')->getData();
            $queryBuilder = $livreRepository->recherche($keyword);
            
            $pagination = $paginator->paginate(
                $queryBuilder,
                $request->query->getInt('page', 1),
                9
            );
        }

        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
            'results' => $pagination,
            'keyword' => $keyword,
        ]);
    }
}
