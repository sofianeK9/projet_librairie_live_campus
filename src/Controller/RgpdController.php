<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RgpdType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RgpdController extends AbstractController
{
    #[Route('/rgpd', name: 'app_rgpd')]
    public function RgpdValidation(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(RGPDType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user instanceof User && $form->get('consentement')->getData() === true) {
                $user->setConsentement(true);

                // préparation de la requête et envoit de la requête
                $entityManager->persist($user);
                $entityManager->flush();

                // Redirige vers le formulaire commun si le consentement est true
                return $this->redirectToRoute('app_formulaire_commun');
            }
        } elseif ($user instanceof User && $form->get('consentement')->getData() === false) {
            $form->get('consentement')->addError(new FormError('Vous devez valider le règlement RGPD afin de pouvoir continuer'));
        }
        return $this->render('rgpd/index.html.twig', [
            'controller_name' => 'RgpdController',
        ]);
    }
}
