<?php

namespace App\Tests\Factory;

use App\Entity\Book;
use App\Enum\Genre;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Book::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'author' => AuthorFactory::createOne(),
            'genre' => self::faker()->randomElement(Genre::cases()),
            'isbn' => self::faker()->text(13),
            'publicationDate' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'title' => self::faker()->text(255),
        ];
    }
}
