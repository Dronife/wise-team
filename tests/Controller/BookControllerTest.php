<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Enum\Genre;
use App\Tests\Factory\AuthorFactory;
use App\Tests\Factory\BookFactory;
use App\Tests\Util\StringNormalizer;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BookControllerTest extends WebTestCase
{
    use ResetDatabase;
    use Factories;

    private readonly KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function testIndexRender(): void
    {

        $this->createBook();

        $this->client->request('GET', '/books/');

        $actual = $this->client->getResponse()->getContent();

        $actual = StringNormalizer::normalize($actual);

        $this->assertSame(trim(file_get_contents('./tests/Fixture/Html/Book/index.html')), $actual);
    }
//
    public function testWrongInputs()
    {
        AuthorFactory::createOne(['name' => 'My name is test']);

        $this->client->request(
            'POST',
            '/books/new',
            [
                'book' => [
                    'name' => 'My name is test',
                    'title' => 123,
                    'isbn' => 123,
                    'genre' => 'Romanc1e',
                    'author' => 1,
                    'publicationDate' => '2010-10-10',
                    'numberOfCopies' => -1000000
                ],
            ],
        );

        $actual = $this->client->getResponse()->getContent();
        $actual = StringNormalizer::normalize($actual);

        $this->assertSame(trim(file_get_contents('./tests/Fixture/Html/Book/new.incorrect.html')), $actual);
    }

    public function testDeletion(): void
    {
        $book = $this->createBook();

        $this->client->request('DELETE', sprintf('/authors/%s', $book->getId()));

        $this->assertNull($book->getId());

    }
    public function testUpdate(): void
    {
        $book = $this->createBook();

        $this->client->request(
            'POST',
            sprintf('/books/%d/edit', $book->getId()),
            [
                'book' => [
                    'title' => 'not superbook',
                    'isbn' => '1233333333333',
                    'genre' => Genre::CHILDREN->value,
                    'author' => 1,
                    'publicationDate' => '2010-10-10',
                    'numberOfCopies' => 1000000
                ],
            ],
        );

        $this->assertSame(BookFactory::find(['id' => 1])->getTitle(), 'not superbook');
    }

    private function createBook(): Book | Proxy
    {
        $author = AuthorFactory::createOne(['name' => 'Tom Joe']);
        return BookFactory::createOne(
            [
                'author' => $author,
                'title' => 'Superbook',
                'isbn' => '9823071487663',
                'publicationDate' => new \DateTimeImmutable('2017-10-22'),
                'genre' => Genre::BIOGRAPHY,
                'numberOfCopies' => 100
            ]
        );
    }
}
