<?php

declare(strict_types=1);

namespace App\Transaction\Domain\Projection;

use App\Account\Domain\Event\MoneySpent;
use App\Transaction\Domain\Repository\TransactionRepositoryInterface;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class TransactionLogger implements MessageConsumer
{
    public function __construct(private TransactionRepositoryInterface $repository)
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();

        $amount = $event->getAmount();
        if ($event instanceof MoneySpent) {
            $amount = -$event->getAmount();
        }

        $this->repository->addTransaction(
            $event->getUserId(),
            $event->getAccountId(),
            $amount,
            $event->getTimestamp(),
            $event->getComment(),
            $event->getTags()
        );
    }
}