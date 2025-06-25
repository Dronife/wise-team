<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Factory\AuthorFactory;
use App\Tests\Util\StringNormalizer;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AuthorControllerTest extends WebTestCase
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
        AuthorFactory::createOne(['name' => 'My name is test']);

        $this->client->request('GET', '/authors/');

        $actual = $this->client->getResponse()->getContent();

        $actual = StringNormalizer::normalize($actual);

        $this->assertSame(trim(file_get_contents('./tests/Fixture/Html/Author/index.html')), $actual);
    }

    public function testCanNotAddWithExistingName()
    {
        AuthorFactory::createOne(['name' => 'My name is test']);

        $this->client->request(
            'POST',
            '/authors/new',
            [
                'author' => [
                    'name' => 'My name is test',
                ],
            ],
        );

        $actual = $this->client->getResponse()->getContent();
        $actual = StringNormalizer::normalize($actual);
        $this->assertSame(trim(file_get_contents('./tests/Fixture/Html/Author/new.existing.html')), $actual);
    }

    public function testDeletion(): void
    {
        $author = AuthorFactory::createOne(['name' => 'My name is test'])->_disableAutoRefresh();
        $this->client->request('DELETE', sprintf('/authors/%s', $author->getId()));

        $this->assertNull($author->getId());

    }

    public function testUpdate(): void
    {

        $author = AuthorFactory::createOne(['name' => 'test1'])->_disableAutoRefresh();
        $this->client->request(
            'POST',
            sprintf('/authors/%d/edit', $author->getId()),
            [
                'author' => [
                    'name' => 'changed',
                ],
            ],
        );

        $this->assertSame($author->getName(), 'changed');
    }
}
