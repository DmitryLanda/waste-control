<?php

declare(strict_types=1);

namespace App\User\Http;

class CreateUser
{
    public function __construct(private string $fullName, private string $email)
    {
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}