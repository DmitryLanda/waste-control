<?php

declare(strict_types=1);

namespace App\User\Domain;

interface UserRepositoryInterface
{
    public function findOneById(string $id): ?User;

    public function save(User $user): void;
}