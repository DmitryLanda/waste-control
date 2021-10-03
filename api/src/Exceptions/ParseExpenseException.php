<?php

namespace App\Exceptions;

use Throwable;

class ParseExpenseException extends AppException
{
    public static function badInput(): self
    {
        throw new self('Данные должны быть в виде "<сумма> <дата> <категория>"');
    }

    public static function wrongValue(): self
    {
        return new self('Сумма должна быть числом');
    }

    public static function wrongCategory(): self
    {
        return new self('Категория обязательна');
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