<?php

namespace App\Account\Infrastructure;

use App\Account\Domain\Account;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use App\Shared\EventSourcing\DoctrineAggregateRootRepositoryWithSnapshotting;

final class AccountRepository extends DoctrineAggregateRootRepositoryWithSnapshotting implements AccountRepositoryInterface
{
    protected function getAggregateRootClassName(): string
    {
        return Account::class;
    }
}