<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory as FakerFactory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    // propriétés privées qui seront utilisées au sein de la classe 
    // faker permet de créér des valeurs fictives
    private $faker;
    // hasher permet de hasher le MDP
    private $hasher;
    // manager s'occuper de la gestion des objets et de leur intéraction avec la BDD    
    private $manager;

    // le constructeur prend en argument UserPasswordHasherInterface $hasher ce qui signifie qu'une instance de ce dernier doit étre passée
    // lors de la création d'une instance AppFixtures.

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        // une instance est crée pour la langue et le haschage du MDP
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public static function getGroups(): array
    {
        // La méthode statique getGroups de la classe retourne un tableau contenant les noms des groupes auxquels cette fixture appartient.
        //  Dans cet exemple, la fixture appartient aux groupes 'prod' et 'test'.
        return ['prod', 'test'];
    }
    public function load(ObjectManager $manager): void
    {
        
        $this->manager = $manager;
        $this->loadAdmins();

        $manager->flush();
    }

    public function loadAdmins()
    {
        $datas = [
            [
                'email' => 'admin@exemple.com',
                'password' => '123',
                'roles' => ['ROLE_ADMIN'],

            ]
        ];

        foreach ($datas as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $password = $this->hasher->hashPassword($user, $data['password']);
            $user->setPassword($password);
            $user->setRoles(['roles']);

            $this->manager->persist($user);
        }
        $this->manager->flush();
    }
}
