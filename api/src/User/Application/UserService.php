<?php

declare(strict_types=1);

namespace App\User\Application;

use App\Money\Application\AccountService;
use App\User\Domain as Domain;
use App\User\Domain\UserRepositoryInterface;
use App\User\Http\CreateUser;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private AccountService          $accountService
    ) {
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
        $this->accountService->createNewAccount($user->getId());

        return User::fromDomain($user);
    }
}