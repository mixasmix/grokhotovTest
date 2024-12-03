<?php

namespace App\Repository\Category;

use App\Entity\Category;

interface CategoryRepositoryInterface
{
    public function findByName(string $name): ?Category;
}
