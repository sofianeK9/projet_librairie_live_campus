<?php
// ce fichier se trouve dans le dossier datafixtures
namespace App\DataFixtures;

// Ici on fait appelle aux classes que l'on utilise pour créér des données fictives 
use DateTime;
use App\Entity\User;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use DateTimeImmutable;
// Fournit des méthodes pour la création de données fictives et on appelle des dependances (gestionnaire d'objet->manager)
// qui permettent de créer des donées fictives, et de faire des operations d'écritures.
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

// C'est le gestionnaire d'objet
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

// Permet de hascher le mot de passe
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Cette classe contient un constructeur et des propriétés privées pour la création de données et de gestion de ces données.
class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }
    // Cette méthode précise à quelle groupe la classe appartient -> au groupe test.
    public static function getGroups(): array
    {
        return ['test'];
    }

    // Cette méthode est utilisée pour charger les données de test dans la BDD à l'aide de Doctrine (qui est un gestionnaire d'objet)
    public function load(ObjectManager $manager): void
    {
        //  Cette ligne de code assigne l'objet $manager passé en argument à l'attribut $manager de la classe AppFixtures
        // Grace à ca, cela permet à la classe d'accéder au gestionnaire d'objet tout au long de la méthode load.
        $this->manager = $manager;
        $this->loadAuteurs();
        $this->loadGenres();
        $this->loadLivres();
        $this->loadEmprunteurs();
        $this->loadEmprunts();
    }

    public function loadAuteurs(): void
    {
        $datas = [
            [
                'nom' => 'Bob',
                'prenom' => 'Dylan'
            ],
            [
                'nom' => 'Victor',
                'prenom' => 'Hugo'
            ],
            [
                'nom' => 'Martin',
                'prenom' => 'Luther King'
            ],
            [
                'nom' => 'Albert',
                'prenom' => 'Camus'
            ],
            [
                'nom' => 'Sun',
                'prenom' => 'Tzu'
            ],
            [
                'nom' => 'Lao',
                'prenom' => 'Tseu'
            ],
        ];

        foreach ($datas as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['prenom']);

            $this->manager->persist($auteur);
        }
        $this->manager->flush();
        for ($i = 0; $i < 500; $i++) {
            $auteur = new Auteur();
            $auteur->setNom($this->faker->LastName());
            $auteur->setPrenom($this->faker->FirstName());

            $this->manager->persist($auteur);
        }
        $this->manager->flush();
    }

    public function loadGenres(): void
    {
        $datas = [
            [
                'nom' => 'Fantastique',
                'description' => null
            ],
            [
                'nom' => 'Nouvelle',
                'description' => null
            ],
            [
                'nom' => 'Poésie',
                'description' => null
            ],
            [
                'nom' => 'Roman historique',
                'description' => null
            ],
            [
                'nom' => 'Biographie',
                'description' => null
            ],
            [
                'nom' => 'Conte',
                'description' => null
            ],
            [
                'nom' => 'Essai',
                'description' => null
            ],
            [
                'nom' => 'Journal intime',
                'description' => null
            ],
            [
                'nom' => 'Politique',
                'description' => null
            ],
            [
                'nom' => 'Economie',
                'description' => null
            ]
        ];

        foreach ($datas as $data) {
            $genre = new Genre();
            $genre->setNom($data['nom']);
            $genre->setDescription($data['description']);

            $this->manager->persist($genre);
        }
        $this->manager->flush();
    }

    public function loadLIvres(): void
    {
        $repositoryAuteur = $this->manager->getRepository(Auteur::class);
        $auteurs = $repositoryAuteur->findAll();
        $auteur1 = $repositoryAuteur->find(1);
        $auteur2 = $repositoryAuteur->find(2);
        $auteur3 = $repositoryAuteur->find(3);
        $auteur4 = $repositoryAuteur->find(4);

        $repositoryGenre = $this->manager->getRepository(Genre::class);
        $genres = $repositoryGenre->findAll();
        $genre1 = $repositoryGenre->find(1);
        $genre2 = $repositoryGenre->find(2);
        $genre3 = $repositoryGenre->find(3);
        $genre4 = $repositoryGenre->find(4);

        $datas = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'anneeEdition' => 2010,
                'nombrePages' => 300,
                'codeIsbn' => '9785786930024',
                'auteurs' => $auteur1,
                'genres' => [$genre1]
            ],
            [
                'titre' => 'Art de la guerre',
                'anneeEdition' => 2033,
                'nombrePages' => 150,
                'codeIsbn' => '9785786931145',
                'auteurs' => $auteur2,
                'genres' => [$genre3]
            ],
            [
                'titre' => 'Les trois royaumes',
                'anneeEdition' => 2008,
                'nombrePages' => 340,
                'codeIsbn' => '9785786785463',
                'auteurs' => $auteur3,
                'genres' => [$genre3]
            ],
            [
                'titre' => 'Les misérables',
                'anneeEdition' => 2014,
                'nombrePages' => 250,
                'codeIsbn' => '1236786785463',
                'auteurs' => $auteur4,
                'genres' => [$genre4]
            ]
        ];

        foreach ($datas as $data) {
            $livre = new livre();
            $livre->setTitre($data['titre']);
            $livre->setAnneeEdition($data['anneeEdition']);
            $livre->setNombrePages($data['nombrePages']);
            $livre->setCodeIsbn($data['codeIsbn']);
            $livre->setAuteur($data['auteurs']);

            $livre->addGenre($data['genres'][0]);

            $this->manager->persist($livre);
        };
        $this->manager->flush();

        // données dynamiques

        for ($i = 0; $i < 1000; $i++) {
            $livre = new Livre();
            $words = random_int(2, 5);
            $livre->setTitre($this->faker->unique()->sentence($words));
            $livre->setAnneeEdition($this->faker->optional(0.9)->year());
            $livre->setNombrePages($this->faker->numberBetween(100, 1000));
            $livre->setCodeIsbn($this->faker->unique()->isbn13());

            $auteur = $this->faker->randomElement($auteurs);
            $livre->setAuteur($auteur);

            $nbGenres = random_int(1, 3);
            $shortList = $this->faker->randomElements($genres, $nbGenres);

            foreach ($shortList as $genre) {
                $livre->addGenre($genre);
            }
            $this->manager->persist($livre);
        }

        $this->manager->flush();
    }

    public function loadEmprunteurs(): void
    {
        $datas = [
            [
                'email' => 'foo.foo@exemple.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',

                'nom' => 'Charles',
                'prenom' => 'Magnus',
                'tel' => '0785455995',
                'createdAt' => new DateTime('2023-03-01 10:00:00')
            ],
            [
                'email' => 'bar.bar@exemple.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',

                'nom' => 'Jack',
                'prenom' => 'Sparrow',
                'tel' => '0785455995',
                'createdAt' => new DateTime('2023-03-01 10:00:00')
            ],
            [
                'email' => 'baz.baz@exemple.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',

                'nom' => 'Ethan',
                'prenom' => 'Brown',
                'tel' => '0785455775',
                'createdAt' => new DateTime('2023-03-01 10:00:00')
            ]
        ];
        foreach ($datas as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $password = $this->hasher->hashPassword($user, $data['password']);
            $user->setPassword($password);
            $user->setRoles($data['roles']);


            $this->manager->persist($user);

            $emprunteur = new Emprunteur();

            $emprunteur->setNom($data['nom']);
            $emprunteur->setPrenom($data['prenom']);
            $emprunteur->setTel($data['tel']);
            $emprunteur->setCreatedAt($data['createdAt']);

            $emprunteur->setUser($user);


            $this->manager->persist($emprunteur);
        }

        $this->manager->flush();

        // données dynamiques

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($this->faker->safeEmail());
            $password = $this->hasher->hashPassword($user, '123');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);

            $this->manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur->setNom($this->faker->lastName());
            $emprunteur->setPrenom($this->faker->firstName());
            $emprunteur->setTel($this->faker->phoneNumber());

            $emprunteur->setUser($user);

            $this->manager->persist($emprunteur);
        }
        $this->manager->flush();
    }

    public function loadEmprunts(): void
    {
        $repositoryLivres = $this->manager->getRepository(Livre::class);
        $livres = $repositoryLivres->findAll();
        $livre1 = $repositoryLivres->find(1);
        $livre2 = $repositoryLivres->find(2);
        $livre3 = $repositoryLivres->find(3);


        $repositoryEmprunteur = $this->manager->getRepository(Emprunteur::class);
        $emprunteurs = $repositoryEmprunteur->findAll();
        $emprunteur1 = $repositoryEmprunteur->find(1);
        $emprunteur2 = $repositoryEmprunteur->find(2);
        $emprunteur3 = $repositoryEmprunteur->find(3);

        // données statiques
        $datas = [
            [
                'dateEmprunt' => new DateTime('2020-02-01 10:00:00'),
                'dateRetour' => new DateTime('2020-03-01 10:00:00'),
                'emprunteur' => $emprunteur1,
                'livre' => $livre1,
            ],
            [
                'dateEmprunt' => new DateTime('2020-03-01 10:00:00'),
                'dateRetour' => new DateTime('2020-04-01 10:00:00'),
                'emprunteur' => $emprunteur2,
                'livre' => $livre2,
            ],
            [
                'dateEmprunt' => new DateTime('2020-04-01 10:00:00'),
                'dateRetour' => null,
                'emprunteur' => $emprunteur3,
                'livre' => $livre3,
            ],
        ];
        foreach ($datas as $data) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($data['dateEmprunt']);
            $emprunt->setDateRetour($data['dateRetour']);
            $emprunt->setEmprunteur($data['emprunteur']);
            $emprunt->setLivre($data['livre']);

            $this->manager->persist($emprunt);
        }
        // données dynamiques

        for ($i = 0; $i < 200; $i++) {
            $emprunt = new Emprunt();

            $dateEmprunt = $this->faker->dateTimeBetween(' -1 year', '-6 months');
            $emprunt->setDateEmprunt($dateEmprunt);

            $dateRetour = $this->faker->optional(0.5)->dateTimeBetween('-6 months', 'now');
            $emprunt->setDateRetour($dateRetour);

            $livre = $this->faker->randomElement($livres);
            $emprunt->setLivre($livre);


            $emprunteur = $this->faker->randomElement($emprunteurs);
            $emprunt->setEmprunteur($emprunteur);

            $this->manager->persist($emprunt);
        }

        $this->manager->flush();
    }
}
