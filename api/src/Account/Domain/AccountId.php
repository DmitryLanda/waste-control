<?php

declare(strict_types=1);

namespace App\Account\Domain;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class AccountId implements AggregateRootId
{
    private function __construct(private string $id)
    {
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }

    public static function generate(): AggregateRootId
    {
        return new static(Uuid::uuid4()->toString());
    }
}