<?php

declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\BookStatus;
use DateTimeImmutable;
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
#[ApiFilter(filterClass: SearchFilter::class, properties: ['title', 'author.name', 'status'])]
#[ApiFilter(filterClass: DateFilter::class, properties: ['publishedDate'])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column]
    private string $title;

    #[ORM\Column(nullable: true)]
    private ?string $isbn;

    #[ORM\Column]
    private int $pageCount;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $publishedDate;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $thumbnailUrl;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $longDescription;

    #[ORM\Column(enumType: BookStatus::class)]
    private BookStatus $status;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $authors;

    public function __construct(
        string $title,
        int $pageCount,
        BookStatus $status,
        ?DateTimeImmutable $publishedDate = null,
        ?string $isbn = null,
        ?string $thumbnailUrl = null,
        ?string $longDescription = null,
        array|Collection $categories = [],
        array|Collection $authors = [],
    ) {
        $this->title = $title;
        $this->isbn = $isbn;
        $this->pageCount = $pageCount;
        $this->publishedDate = $publishedDate;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->longDescription = $longDescription;
        $this->status = $status;
        $this->categories = $categories instanceof ArrayCollection ? $categories : new ArrayCollection($categories);
        $this->authors = $authors instanceof ArrayCollection ? $authors : new ArrayCollection($authors);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function getPublishedDate(): ?DateTimeImmutable
    {
        return $this->publishedDate;
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnailUrl;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function getStatus(): BookStatus
    {
        return $this->status;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function setPageCount(int $pageCount): self
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function setPublishedDate(?DateTimeImmutable $publishedDate): self
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    public function setThumbnailUrl(?string $thumbnailUrl): self
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    public function setLongDescription(?string $longDescription): self
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function setStatus(BookStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setCategories(Collection $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function setAuthors(Collection $authors): self
    {
        $this->authors = $authors;

        return $this;
    }
}
