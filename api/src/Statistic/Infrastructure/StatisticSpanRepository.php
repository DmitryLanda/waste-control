<?php

declare(strict_types=1);

namespace App\Statistic\Infrastructure;

use App\Statistic\Domain\Repository\StatisticSpanRepositoryInterface;
use App\Statistic\Domain\StatisticSpan;
use App\Statistic\Infrastructure\Orm\StatsSpan;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class StatisticSpanRepository implements StatisticSpanRepositoryInterface
{
    private const DAY = 'day';
    private const WEEK = 'week';
    private const MONTH = 'month';
    private const YEAR = 'year';
    private ObjectRepository $ormRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->ormRepository = $this->entityManager->getRepository(StatsSpan::class);
    }

    public function getAccountStats(string $account): array
    {
        $entities = $this->ormRepository->findBy(['accountId' => $account], ['finishDate' => 'DESC'], 4);

        return array_map(function (StatsSpan $entity) {
            return new StatisticSpan(
                $entity->getType(),
                $entity->getStartDate(),
                $entity->getFinishDate(),
                $entity->getIncome(),
                $entity->getSpends()
            );
        }, $entities);
    }

    public function updateSpan(
        string            $userId,
        string            $accountId,
        DateTimeInterface $date,
        float             $income,
        float             $spends
    ): void {
        $morning = '00:00:00';
        $evening = '23:59:59';
        $month = $date->format('F');
        $year = $date->format('Y');

        $dayStart = (clone $date)->setTime(0, 0, 0);
        $dayEnd = (clone $date)->setTime(23, 59, 59);
        $weekStart = new DateTime("monday this week $morning");
        $weekEnd = new DateTime("sunday this week $evening");
        $monthStart = new DateTime("first day of $month $morning");
        $monthEnd = new DateTime("last day of $month $evening");
        $yearStart = new DateTime("first day of January $year $morning");
        $yearEnd = new DateTime("last day of December $year $evening");

        $sql = "insert into stat_spans (user_id, account_id, start_date, finish_date, income, spends, type) 
            values
                (:user, :account, ?, ?, :income, :spends, ?),
                (:user, :account, ?, ?, :income, :spends, ?),
                (:user, :account, ?, ?, :income, :spends, ?),
                (:user, :account, ?, ?, :income, :spends, ?)
            on conflict on constraint unique_stats_span DO UPDATE set 
                spends = stat_spans.spends + EXCLUDED.spends,
                income = stat_spans.income + EXCLUDED.income";

        $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'user'    => $userId,
                'account' => $accountId,
                'income'  => $income,
                'spends'  => $spends,
                $dayStart,
                $dayEnd,
                self::DAY,
                $weekStart,
                $weekEnd,
                self::WEEK,
                $monthStart,
                $monthEnd,
                self::MONTH,
                $yearStart,
                $yearEnd,
                self::YEAR,
            ],
            [
                'user'    => Types::STRING,
                'account' => Types::STRING,
                'income'  => Types::DECIMAL,
                'spends'  => Types::DECIMAL,
                Types::DATETIME_MUTABLE,
                Types::DATETIME_MUTABLE,
                Types::STRING,
                Types::DATETIME_MUTABLE,
                Types::DATETIME_MUTABLE,
                Types::STRING,
                Types::DATETIME_MUTABLE,
                Types::DATETIME_MUTABLE,
                Types::STRING,
                Types::DATETIME_MUTABLE,
                Types::DATETIME_MUTABLE,
                Types::STRING,
            ]
        );
    }
}