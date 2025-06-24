<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\BookProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/books', name: 'book_')]
class BookController extends AbstractController
{
    public function __construct(
        private readonly BookProvider $bookProvider,
    ) {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $page = (int)$request->query->get('page', 1);
        $perPage = (int)$request->query->get('perPage', 10);

        return $this->render(
            $request->isXmlHttpRequest() ?  'book/table.html.twig' : 'book/index.html.twig',
            [
                'books' => $this->bookProvider->getAllPaginated($page, $perPage),
            ],
        );
    }
}