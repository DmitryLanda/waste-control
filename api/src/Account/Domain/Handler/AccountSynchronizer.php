<?php

declare(strict_types=1);

namespace App\Account\Domain\Handler;

use App\Account\Domain\Event\AccountCreated;
use App\Account\Domain\Event\MoneyAdded;
use App\Account\Domain\Event\MoneySpent;
use App\Account\Domain\Repository\UserAccountRepositoryInterface;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;

class AccountSynchronizer implements MessageConsumer
{
    public function __construct(private UserAccountRepositoryInterface $repository)
    {

    }

    public function handle(Message $message): void
    {
        $event = $message->payload();

        if ($event instanceof AccountCreated) {
            $this->linkUserWithNewAccount($event->getUserId(), $event->getAccountId());
        } elseif ($event instanceof MoneySpent) {
            $this->decrementBalance($event->getUserId(), $event->getAccountId(), $event->getAmount());
        } elseif ($event instanceof MoneyAdded) {
            $this->incrementBalance($event->getUserId(), $event->getAccountId(), $event->getAmount());
        }
    }

    private function linkUserWithNewAccount(string $userId, string $accountId)
    {
        $this->repository->save($userId, $accountId);
    }

    private function incrementBalance(string $userId, string $accountId, float $amount)
    {
        $this->repository->incrementBalance($userId, $accountId, $amount);
    }

    private function decrementBalance(string $userId, string $accountId, float $amount)
    {
        $this->repository->decrementBalance($userId, $accountId, $amount);
    }
}