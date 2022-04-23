<?php

declare(strict_types=1);

namespace App\Statistic\Infrastructure\Orm;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'category_stats')]
#[ORM\UniqueConstraint(name: 'unique_category_stat', fields: ['accountId', 'name'])]
final class CategoryStatistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 36)]
    private string $userId;

    #[ORM\Column(type: 'string', length: 36)]
    private string $accountId;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $counter;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }
}
