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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RgpdController extends AbstractController
{
    #[Route('/rgpd', name: 'app_rgpd')]
    public function RgpdValidation(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(RgpdType::class, $user);

        if ($form->isSubmitted() && $form->isValid()) {
            // Log in the user and redirect
            return $security->login(
                $user,
                LoginFormAuthenticator::class,
                'main'
            );
        }
        return $this->render('rgpd/index.html.twig', [
            'controller_name' => 'RgpdController',
        ]);
    }
}
