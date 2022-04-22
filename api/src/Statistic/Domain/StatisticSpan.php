<?php

declare(strict_types=1);

namespace App\Statistic\Domain;

use DateTimeInterface;

final class StatisticSpan
{
    public function __construct(
        private string $type,
        private DateTimeInterface $from,
        private DateTimeInterface $to,
        private float $income,
        private float $spends
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFrom(): DateTimeInterface
    {
        return $this->from;
    }

    public function getTo(): DateTimeInterface
    {
        return $this->to;
    }

    public function getIncome(): float
    {
        return $this->income;
    }

    public function getSpends(): float
    {
        return $this->spends;
    }
}