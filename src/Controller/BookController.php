<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/books', name: 'book_')]
class BookController extends AbstractController
{
    public function __construct(
        private readonly BookRepository $bookRepository,
    ) {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $this->bookRepository->findAll(),
        ]);
    }
}