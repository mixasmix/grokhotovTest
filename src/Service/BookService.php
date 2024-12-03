<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\Book;
use App\Repository\Book\BookRepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class BookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function createFromArray(array $bookData): Book
    {
        $bookData['publishedDate'] = $bookData['publishedDate']['$date'] ?? null;

        $book = $this->serializer->denormalize($bookData, Book::class);

        $this->bookRepository->add($book, true);

        return $book;
    }
}
