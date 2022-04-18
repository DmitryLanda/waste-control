<?php

declare(strict_types=1);

namespace App\Account\Domain\Repository;

interface UserAccountRepositoryInterface
{
    public function save(string $accountName, string $userId, string $accountId): void;

    public function incrementBalance(string $userId, string $accountId, float $amount): void;

    public function decrementBalance(string $userId, string $accountId, float $amount): void;

    public function findByUserId(string $userId): array;
}