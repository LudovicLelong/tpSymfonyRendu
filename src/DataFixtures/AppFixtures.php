<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\User;
use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    /**
     * generatior appel
     */
    private Generator $faker;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher= $hasher;
    }


    public function load(ObjectManager $manager): void
    {

        for ($i=0; $i <= 79; $i++) {
            $livres = new livres();
            $livres->setName($this->faker->word())
            ->setPrice(mt_rand(0, 550))
            ->setDescription($this->faker->text());

            $manager->persist($livres);
        }

        
         // Users
         for ($i = 0; $i < 10; $i++) {
             $user = new User();
             $user->setFullName($this->faker->name())
                 ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                 ->setEmail($this->faker->email())
                 ->setRoles(['ROLE_USER']);
               
            $hashPassword = $this->hasher->hashPassword( 
                $user,
                'password'
            );

            $user->setPassword($hashPassword);
 
             $manager->persist($user);
         }





         
         // Author
         for ($i=0; $i <= 79; $i++) {
            $author = new Author();
            $author->setPrenom($this->faker->word());

            $manager->persist($author);
        }







 

        $manager->flush();

    }
}
