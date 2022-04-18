<?php

declare(strict_types=1);

namespace App\Transaction\Application\Dto;

final class SearchTransactions
{
    private int $page;
    private int $limit;

    public function __construct(int|string $page = 1, int|string $limit = 50)
    {
        $this->page = (int)$page;
        $this->limit = (int)$limit;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getLimit()
    {
        return $this->limit;
    }
}