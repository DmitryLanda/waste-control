<?php

namespace App\Dto;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ExpenseRequest
{
    #[Assert\NotBlank(message: 'Укажите сумму')]
    #[Assert\NotEqualTo(value: 0, message: 'Сумма не должан быть нулевой')]
    public ?float $value = null;

    #[Assert\NotBlank(message: 'Укажите категорию')]
    public ?string $category = null;

    #[Assert\Date(message: 'Укажите дату')]
    public ?string $date;

    public function __construct(
        ?float $value = null,
        ?string $category = null,
        ?DateTimeInterface $date = null
    ) {
        $this->value = $value;
        $this->category = $category;
        $this->date = $date;
    }

    public function getDate(): DateTimeInterface
    {
        return new DateTimeImmutable($this->date);
    }
}