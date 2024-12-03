<?php

declare(strict_types = 1);

namespace App\Repository\User;

use App\Entity\User;
use App\Repository\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return User::class;
    }
}
