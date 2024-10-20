<?php

namespace App\Form;

use App\Entity\Emprunteur;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class UserType extends AbstractType
{
    private $roleHierarchy;

    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = $this->getAvailableRoles();

        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => $roles,
                'multiple' => true,  // Permet de sélectionner plusieurs rôles
                'expanded' => true,   // Affiche les rôles sous forme de cases à cocher
            ])
            ->add('password')
            ->add('emprunteur', EmprunteurType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * Récupère les rôles disponibles dans la hiérarchie.
     */
    private function getAvailableRoles(): array
    {
        $allRoles = $this->roleHierarchy->getReachableRoleNames(['ROLE_USER', 'ROLE_ADMIN']); // Ajuste selon ta hiérarchie de rôles
        $choices = [];
        foreach ($allRoles as $role) {
            $choices[$role] = $role;
        }
        return $choices;
    }
}

