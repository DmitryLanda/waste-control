<?php

namespace App\Exceptions;

use Throwable;

class ParseExpenseException extends AppException
{
    public static function badInput(): self
    {
        throw new self('Данные должны быть в виде "<сумма> <дата> <категория>"');
    }

    public static function shouldBePositive(): self
    {
        return new self('Сумма должна быть положительным числом');
    }


    public static function shouldBeNumeric(): self
    {
        return new self('Сумма должна быть числом');
    }

    public static function stringIsEmpty(): self
    {
        return new self('Пояснение обязательно');
    }

    public static function dateInFuture(): self
    {
        return new self('Дата не должна быть в будущем');
    }

    public static function wrongDate(?Throwable $previous = null): self
    {
        return new self('Не получилось распознать дату', 0, $previous);
    }
}