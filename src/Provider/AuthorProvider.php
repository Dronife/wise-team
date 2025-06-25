<?php

declare(strict_types=1);

namespace App\Provider;

use App\Repository\AuthorRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class AuthorProvider
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    public function getAllPaginated(int $page = 1, int $perPage = 10): PaginationInterface
    {
        $bookQuery = $this->authorRepository->findAllQuery();

        return $this->paginator->paginate(
            $bookQuery,
            $page,
            $perPage,
        );
    }
}