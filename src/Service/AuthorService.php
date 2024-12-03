<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\Author;
use App\Repository\Author\AuthorRepositoryInterface;

final readonly class AuthorService
{
    public function __construct(private AuthorRepositoryInterface $authorRepository)
    {
    }

    public function create(string $name): Author
    {
        $author = $this->authorRepository->findByName($name);

        if (is_null($author)) {
            $author = new Author(name: $name);

            $this->authorRepository->add($author);
        }

        return $author;
    }
}
