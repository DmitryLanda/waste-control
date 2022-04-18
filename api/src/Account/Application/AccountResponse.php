<?php

declare(strict_types=1);

namespace App\Account\Application;

final class AccountResponse
{
    private function __construct(
        private string $id,
        private string $name,
        private float  $total
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['accountId'],
            $data['accountName'],
            $data['amount'],
        );
    }
}