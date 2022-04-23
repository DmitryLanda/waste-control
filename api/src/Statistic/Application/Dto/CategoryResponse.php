<?php

declare(strict_types=1);

namespace App\Statistic\Application\Dto;

use App\Statistic\Domain\Category;

final class CategoryResponse
{
    private function __construct(private string $name)
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromDomain(Category $category)
    {
        return new self($category->getName());
    }
}