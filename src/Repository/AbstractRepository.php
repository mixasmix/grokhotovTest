<?php

declare(strict_types = 1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository implements Repository
{
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository($this->getEntityClass());
    }

    public function add(object $entity, bool $isFlush = false): object
    {
        $this->entityManager->persist($entity);

        if ($isFlush) {
            $this->entityManager->flush();
        }

        return $entity;
    }

    public function getRepository(): EntityRepository
    {
        return $this->repository;
    }

    abstract protected function getEntityClass(): string;

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
