<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\Category;
use App\Repository\Category\CategoryRepositoryInterface;

final readonly class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function create(string $name): Category
    {
        $category = $this->categoryRepository->findByName(name: $name);

        if (is_null($category)) {
            $category = new Category(name: $name);

            $this->categoryRepository->add($category);
        }

        return $category;
    }
}
