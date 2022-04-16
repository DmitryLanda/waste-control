<?php

declare(strict_types=1);

namespace App\User\Domain;

use Ramsey\Uuid\Uuid;

class User
{
    public function __construct(private string $id, private string $fullName, private string $email)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function create(string $fullName, string $email): self
    {
        return new self(
            Uuid::uuid4()->toString(),
            $fullName,
            $email
        );
    }
}