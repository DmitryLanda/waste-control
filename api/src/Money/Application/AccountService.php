<?php

declare(strict_types=1);

namespace App\Money\Application;

use App\Money\Domain\Account;
use App\Money\Domain\AccountId;
use App\Money\Domain\Repository\AccountRepositoryInterface;
use App\Money\Http\Transaction;
use Exception;
use Ramsey\Uuid\UuidInterface;

class AccountService
{
    public function __construct(private AccountRepositoryInterface $repository)
    {

    }

    public function createNewAccount(UuidInterface $userId): string
    {
        $aggregateId = AccountId::generate();
        $account = Account::create($aggregateId, $userId);
        $this->repository->persist($account);

        return $aggregateId->toString();
    }

    /**
     * @throws Exception
     */
    public function registerTransaction(string $accountId, Transaction $transaction): void
    {
        $account = $this->retrieveAccount($accountId);
        if ($transaction->isPositive()) {
            $account->addMoney($transaction->getAmount(), $transaction->getComment());
        } else {
            $account->spendMoney($transaction->getAmount(), $transaction->getComment());
        }

        $this->repository->persist($account);
    }

    /**
     * @throws Exception
     */
    private function retrieveAccount(string $accountId): Account
    {
        $aggregateId = AccountId::fromString($accountId);
        $account = $this->repository->retrieveFromSnapshot($aggregateId);
        if (!$account) {
            throw new Exception("Account #$accountId not exists");
        }

        return $account;
    }
}