<?php

declare(strict_types=1);

namespace App\Statistic\Domain;

final class Category
{
    public function __construct(private string $name)
    {

    }

    public function getName(): string
    {
        return $this->name;
    }
}