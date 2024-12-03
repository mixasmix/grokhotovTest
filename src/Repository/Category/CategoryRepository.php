<?php

declare(strict_types = 1);

namespace App\Repository\Category;

use App\Entity\Category;
use App\Repository\AbstractRepository;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Category::class;
    }

    public function findByName(string $name): ?Category
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }
}
