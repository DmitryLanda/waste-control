<?php

declare(strict_types=1);

namespace App\Money\Domain\Repository;

interface UserAccountRepositoryInterface
{
    public function save(string $userId, string $accountId): void;

    public function incrementBalance(string $userId, string $accountId, float $amount): void;

    public function decrementBalance(string $userId, string $accountId, float $amount): void;
}