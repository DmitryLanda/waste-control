<?php

declare(strict_types=1);

namespace App\Statistic\Infrastructure\Orm;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[ORM\Table(name: 'stat_spans')]
#[ORM\UniqueConstraint(name: 'unique_stats_span', fields: ['userId', 'accountId', 'startDate', 'finishDate'])]
final class StatsSpan
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 36)]
    private string $userId;

    #[ORM\Column(type: 'string', length: 36)]
    private string $accountId;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $startDate;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $finishDate;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private float $income;

    #[ORM\Column(type: 'decimal', scale: 2)]
    private float $spends;

    #[ORM\Column(type: 'string')]
    private string $type;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getIncome(): float
    {
        return $this->income;
    }

    public function getSpends(): float
    {
        return $this->spends;
    }

    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    public function getFinishDate(): DateTimeInterface
    {
        return $this->finishDate;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
