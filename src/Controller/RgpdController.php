<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RgpdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Annotation\Route;

class RgpdController extends AbstractController
{
    #[Route('/rgpd', name: 'app_rgpd')]
    public function RgpdValidation(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RgpdType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user instanceof User && $form->get('consentement')->getData() === true) {
                $user->setConsentement(true);

                // Sauvegarder le consentement
                $entityManager->persist($user);
                $entityManager->flush();

                // Rediriger vers le formulaire d'emprunteur
                return $this->redirectToRoute('app_emprunteur');
            }
        } elseif ($user instanceof User && $form->get('consentement')->getData() === false) {
            $form->get('consentement')->addError(new FormError('Vous devez valider le règlement RGPD afin de pouvoir continuer'));
        }

        return $this->render('rgpd/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
