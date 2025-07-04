<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use App\Enum\Genre;
use App\Enum\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUser($manager);

        $faker = Factory::create();

        $authors = [];
        for ($i = 0; $i < 10; $i++) {
            $author = (new Author())
                ->setName($faker->name)
            ;

            $manager->persist($author);
            $authors[] = $author;
        }

        for ($i = 0; $i < 50; $i++) {
            try {
                $book = (new Book())
                    ->setTitle($faker->sentence())
                    ->setPublicationDate(\DateTimeImmutable::createFromInterface($faker->dateTimeBetween('-10 years')))
                    ->setGenre($faker->randomElement(Genre::cases()))
                    ->setIsbn($faker->numberBetween(1000000000000, 9999999999999))
                    ->setAuthor($faker->randomElement($authors))
                    ->setNumberOfCopies($faker->numberBetween(100, 100000))
                ;

                $manager->persist($book);

                $manager->flush();
            } catch (\Throwable) {
                continue;
            }
        }

    }

    private function createUser(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('test@test.com')
            ->setRoles([Role::ROLE_LIBRARIAN])
        ;

        $user->setPassword($this->userPasswordHasher->hashPassword($user,'test123'));

        $manager->persist($user);
        $manager->flush();
    }
}
