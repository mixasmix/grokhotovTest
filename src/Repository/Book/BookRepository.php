<?php

declare(strict_types = 1);

namespace App\Repository\Book;

use App\Entity\Book;
use App\Repository\AbstractRepository;

class BookRepository extends AbstractRepository implements BookRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Book::class;
    }
}
