<?php

declare(strict_types = 1);

namespace App\Repository\Author;

use App\Entity\Author;
use App\Repository\AbstractRepository;

class AuthorRepository extends AbstractRepository implements AuthorRepositoryInterface
{
    public function findByName(string $name): ?Author
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

     protected function getEntityClass(): string
    {
        return Author::class;
    }
}
