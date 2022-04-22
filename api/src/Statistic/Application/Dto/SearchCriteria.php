<?php

declare(strict_types=1);

namespace App\Statistic\Application\Dto;

final class SearchCriteria
{
    public function __construct(private string $period = 'day')
    {
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

}