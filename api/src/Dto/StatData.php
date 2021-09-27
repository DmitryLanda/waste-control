<?php

namespace App\Dto;

use DateTimeInterface;

class StatData
{
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';

    public function __construct(
        public string $type,
        public DateTimeInterface $start,
        public DateTimeInterface $end,
        public int $total,
        public array $expenses
    ) {}
}