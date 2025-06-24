<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Provider\BookProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/books', name: 'book_')]
class BookController extends AbstractController
{
    public function __construct(
        private readonly BookProvider $bookProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $page = (int)$request->query->get('page', 1);
        $perPage = (int)$request->query->get('perPage', 10);

        return $this->render(
            $request->isXmlHttpRequest() ? 'book/table.html.twig' : 'book/index.html.twig',
            [
                'books' => $this->bookProvider->getAllPaginated($page, $perPage),
            ],
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
    ): Response {
        $book = new Book();
        $form = $this->createForm(
            BookType::class, $book, [
            'action' => $this->generateUrl('book_new'),
        ],
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($book);
            $this->entityManager->flush();

            return $this->json(['message' => 'success'], Response::HTTP_OK);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            return $this->render(
                'book/form.html.twig',
                [
                    'form' => $form->createView(),
                ],
                new Response(null, Response::HTTP_UNPROCESSABLE_ENTITY),
            );
        }

        return $this->render(
            'book/form.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }
}