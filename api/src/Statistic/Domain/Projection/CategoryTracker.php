<?php

declare(strict_types=1);

namespace App\Statistic\Domain\Projection;

use App\Account\Domain\Event\MoneySpent;
use App\Statistic\Domain\Repository\CategoryStatisticRepositoryInterface;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class CategoryTracker implements MessageConsumer
{
    public function __construct(private CategoryStatisticRepositoryInterface $repository)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();
        if (!$event instanceof MoneySpent) {
            return;
        }

        $this->repository->recordCategoryUsage(
            $event->getUserId(),
            $event->getAccountId(),
            $event->getTags()
        );
    }
}