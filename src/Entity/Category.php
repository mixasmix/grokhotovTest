<?php

declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: 'is_granted(ROLE_ADMIN)'),
        new Patch(security: 'is_granted(ROLE_ADMIN)'),
        new Delete(security: 'is_granted(ROLE_ADMIN)'),
    ]
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    /**
     * @param string     $name
     * @param Collection $books
     */
    public function __construct(
        #[ORM\Column(unique: true)]
        private string $name,
        #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'categories')]
        private Collection $books = new ArrayCollection())
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBooks(): Collection
    {
        return $this->books;
    }
}
