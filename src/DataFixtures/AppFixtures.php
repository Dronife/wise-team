<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Enum\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $authors = [];

        for ($i = 0; $i < 10; $i++) {
            $author = (new Author())
                ->setName($faker->name)
            ;

            $manager->persist($author);
            $authors[] = $author;
        }

        for ($i = 0; $i < 1000; $i++) {
            $book = (new Book())
                ->setTitle($faker->title)
                ->setPublicationDate(\DateTimeImmutable::createFromInterface($faker->dateTimeBetween('-10 years')))
                ->setGenre($faker->randomElement(Genre::cases()))
                ->setIsbn($faker->numberBetween(100, 100000))
                ->setAuthor($faker->randomElement($authors))
                ->setNumberOfCopies($faker->randomDigit)
            ;

            $manager->persist($book);
        }

        $manager->flush();
    }
}
