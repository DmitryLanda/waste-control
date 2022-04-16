<?php

namespace App\Money\Infrastructure;

use App\Money\Domain\Account;
use App\Money\Domain\Repository\AccountRepositoryInterface;
use App\Shared\Snapshot\DoctrineAggregateRootRepositoryWithSnapshotting;

final class AccountRepository extends DoctrineAggregateRootRepositoryWithSnapshotting implements AccountRepositoryInterface
{
    protected function getAggregateRootClassName(): string
    {
        return Account::class;
    }
}