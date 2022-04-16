<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Domain as Domain;

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

    public static function fromDomain(Domain\User $user): self
    {
        return new self(
            $user->getId(),
            $user->getFullName(),
            $user->getEmail()
        );
    }
}