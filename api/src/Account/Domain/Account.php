<?php

declare(strict_types=1);

namespace App\Account\Domain;

use App\Account\Domain\Event\AccountCreated;
use App\Account\Domain\Event\MoneyAdded;
use App\Account\Domain\Event\MoneySpent;
use DateTimeImmutable;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Snapshotting\AggregateRootWithSnapshotting;
use EventSauce\EventSourcing\Snapshotting\SnapshottingBehaviour;

class Account implements AggregateRootWithSnapshotting
{
    use AggregateRootBehaviour;
    use SnapshottingBehaviour;

    private float $total = 0;
    private string $userId;
    private string $name;

    public static function create(AccountId $id, string $name, string $userId): static
    {
        $account = new static($id);
        $account->recordThat(
            new AccountCreated($id->toString(), $userId, $name, new DateTimeImmutable())
        );

        return $account;
    }

    public function spendMoney(float $amount, string $comment, array $tags = []): void
    {
        $this->recordThat(new MoneySpent(
            $this->userId,
            $this->aggregateRootId()->toString(),
            $amount,
            new DateTimeImmutable(),
            $comment,
            $tags
        ));
    }

    public function addMoney(float $amount, string $comment, array $tags = []): void
    {
        $this->recordThat(new MoneyAdded(
            $this->userId,
            $this->aggregateRootId()->toString(),
            $amount,
            new DateTimeImmutable(),
            $comment,
            $tags
        ));
    }

    public function getTotal(): float
    {
        return round($this->total, 2);
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function isValid(): bool
    {
        return $this->aggregateRootVersion() > 0;
    }

    protected function createSnapshotState(): array
    {
        return [
            'total'   => $this->getTotal(),
            'user_id' => $this->getUserId(),
        ];
    }

    protected static function reconstituteFromSnapshotState(AggregateRootId $id, $state): AggregateRootWithSnapshotting
    {
        $account = new static($id);
        $account->total = (float)$state->total;
        $account->userId = (string)$state->user_id;

        return $account;
    }

    private function applyAccountCreated(AccountCreated $event): void
    {
        $this->total = 0;
        $this->userId = $event->getUserId();
    }

    private function applyMoneySpent(MoneySpent $event): void
    {
        $this->total -= $event->getAmount();
    }

    private function applyMoneyAdded(MoneyAdded $event): void
    {
        $this->total += $event->getAmount();
    }

}