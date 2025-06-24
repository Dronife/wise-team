<?php

declare(strict_types=1);

namespace App\Provider;

use App\Repository\BookRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class BookProvider
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    public function getAllPaginated(int $page = 1, int $perPage = 10): PaginationInterface
    {
        $bookQuery = $this->bookRepository->findAllQuery();

        return $this->paginator->paginate(
            $bookQuery,
            $page,
            $perPage,
        );
    }
}