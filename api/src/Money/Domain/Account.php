<?php

declare(strict_types=1);

namespace App\Money\Domain;

use App\Money\Domain\Event\AccountCreated;
use App\Money\Domain\Event\MoneyAdded;
use App\Money\Domain\Event\MoneySpent;
use DateTimeImmutable;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Snapshotting\AggregateRootWithSnapshotting;
use EventSauce\EventSourcing\Snapshotting\SnapshottingBehaviour;
use Ramsey\Uuid\UuidInterface;

class Account implements AggregateRootWithSnapshotting
{
    use AggregateRootBehaviour;
    use SnapshottingBehaviour;

    private float $total = 0;
    private string $userId;

    public static function create(AccountId $id, UuidInterface $userId): static
    {
        $account = new static($id);
        $account->recordThat(new AccountCreated(new DateTimeImmutable(), $userId));

        return $account;
    }

    public function spendMoney(float $amount, string $comment): void
    {
        $this->recordThat(new MoneySpent(
            $amount,
            new DateTimeImmutable(),
            $comment,
        ));
    }

    public function addMoney(float $amount, string $comment): void
    {
        $this->recordThat(new MoneyAdded(
            $amount,
            new DateTimeImmutable(),
            $comment,
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

    protected function createSnapshotState(): array
    {
        return ['total' => $this->getTotal(), 'user_id' => $this->getUserId()];
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