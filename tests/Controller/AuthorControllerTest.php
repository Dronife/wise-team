<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Fixture\AuthorFactory;
use App\Tests\Util\StringNormalizer;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class AuthorControllerTest extends WebTestCase
{
    use ResetDatabase;

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

}
