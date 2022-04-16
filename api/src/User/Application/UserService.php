<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Domain\UserRepositoryInterface;
use App\User\Http\CreateUser;
use App\User\Domain as Domain;

class UserService
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function findById(string $id): ?User
    {
        $user = $this->repository->findOneById($id);

        return $user ? User::fromDomain($user) : null;
    }

    public function register(CreateUser $request): User
    {
        $user = Domain\User::create($request->getFullName(), $request->getEmail());
        $this->repository->save($user);

        return User::fromDomain($user);
    }
}