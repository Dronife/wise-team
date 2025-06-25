<?php

namespace App\Tests\Fixture;

use App\Entity\Author;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Author>
 */
final class AuthorFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Author::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->text(255),
        ];
    }
}
