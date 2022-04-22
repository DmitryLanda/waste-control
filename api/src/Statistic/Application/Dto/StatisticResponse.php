<?php

declare(strict_types=1);

namespace App\Statistic\Application\Dto;

use App\Statistic\Domain\StatisticSpan;
use DateTimeInterface;

final class StatisticResponse
{
    private function __construct(
        private string            $type,
        private DateTimeInterface $from,
        private DateTimeInterface $to,
        private float $income,
        private float $spends
    ) {
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getSpends(): float
    {
        return $this->spends;
    }

    public static function fromDomain(StatisticSpan $span): self
    {
        return new self(
            $span->getType(),
            $span->getFrom(),
            $span->getTo(),
            $span->getIncome(),
            $span->getSpends(),
        );
    }
}