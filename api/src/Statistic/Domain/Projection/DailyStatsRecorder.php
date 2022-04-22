<?php

declare(strict_types=1);

namespace App\Statistic\Domain\Projection;

use App\Account\Domain\Event\BalanceChanged;
use App\Account\Domain\Event\MoneySpent;
use App\Statistic\Domain\Repository\StatisticRepositoryInterface;
use App\Transaction\Domain\Repository\TransactionRepositoryInterface;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class DailyStatsRecorder implements MessageConsumer
{
    public function __construct(private StatisticRepositoryInterface $repository)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();
        if (!$event instanceof BalanceChanged) {
            return;
        }
        $income = $event->getAmount();
        $spend = 0;
        if ($event instanceof MoneySpent) {
            $income = 0;
            $spend = $event->getAmount();
        }

        $this->repository->updateSpan(
            $event->getUserId(),
            $event->getAccountId(),
            $event->getTimestamp(),
            $income,
            $spend
        );
    }
}