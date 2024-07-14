<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, LivreRepository $LivreRepository, PaginatorInterface $pagination): Response
    {

        $livres = $LivreRepository->findAll();
        $pagination = $pagination->paginate(
            $livres,
            $request->query->getInt('page', 1),
            9 
        );
        return $this->render('home/index.html.twig', [
            'livres' => $pagination,
        ]);
    }
}
