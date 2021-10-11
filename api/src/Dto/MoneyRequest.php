<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class MoneyRequest
{
    #[Assert\NotBlank(message: 'Введите данные')]
    public ?string $expression = null;

    public function __construct(?string $expression = null)
    {
        $this->expression = $expression;
    }
}