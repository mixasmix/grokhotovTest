<?php

namespace App\Repository\Author;

use App\Entity\Author;

interface AuthorRepositoryInterface
{
    public function findByName(string $name): ?Author;
}
