<?php

namespace App\Controller;

use App\Entity\Emprunteur;
use App\Form\EmprunteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmprunteurController extends AbstractController
{
    #[Route('/emprunteur', name: 'app_emprunteur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Assurez-vous que l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Créer une nouvelle instance d'Emprunteur
        $emprunteur = new Emprunteur();

        // Créer le formulaire lié à l'entité Emprunteur
        $form = $this->createForm(EmprunteurType::class, $emprunteur);

        // Soumettre le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Lier l'emprunteur à l'utilisateur connecté
            $emprunteur->setUser($user);

            // Persister l'entité Emprunteur
            $entityManager->persist($emprunteur);

            // Enregistrer les modifications dans la base de données
            $entityManager->flush();

            // Rediriger vers la page d'accueil ou autre
            return $this->redirectToRoute('app_home');
        }

        // Rendre la vue avec le formulaire
        return $this->render('emprunteur/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
