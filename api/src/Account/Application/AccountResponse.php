<?php

declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Domain\Account;

final class AccountResponse
{
    private function __construct(
        private string $id,
        private string $userId,
        private float $total
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public static function fromDomain(Account $account): self
    {
        return new self(
            $account->aggregateRootId()->toString(),
            $account->getUserId(),
            $account->getTotal()
        );
    }
}