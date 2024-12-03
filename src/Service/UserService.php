<?php

declare(strict_types = 1);

namespace App\Service;

use App\Entity\User;
use App\Repository\User\UserRepositoryInterface;

final readonly class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function create(
        string $login,
        array $roles = [],
        ?string $password = null,
        ?string $description = null,
    ): User {
        $user = new User(
            login: $login,
            roles: $roles,
            password: $password,
            description: $description,
        );

        $this->userRepository->add(entity: $user);

        return $user;
    }
}
