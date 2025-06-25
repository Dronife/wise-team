<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Provider\AuthorProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/authors', name: 'author_')]
class AuthorController extends AbstractController
{
    public function __construct(
        private readonly AuthorProvider $authorProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $page = (int)$request->query->get('page', 1);
        $perPage = (int)$request->query->get('perPage', 10);

        return $this->render(
            'author/index.html.twig',
            [
                'authors' => $this->authorProvider->getAllPaginated($page, $perPage),
            ],
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(
            AuthorType::class, $author,
            [
                'action' => $this->generateUrl('author_new'),
            ],
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render(
            'author/form.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author): Response
    {
        $form = $this->createForm(
            AuthorType::class,
            $author,
            [
                'action' => $this->generateUrl('author_edit', ['id' => $author->getId()]),
                'method' => 'POST',
            ],
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($author);
            $this->entityManager->flush();

            return $this->redirectToRoute('author_index');
        }

        return $this->render(
            'author/form.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Author $author): Response
    {
        $this->entityManager->remove($author);
        $this->entityManager->flush();

        $this->addFlash('success', 'Author removed successfully.');

        return $this->redirectToRoute('author_index');
    }
}