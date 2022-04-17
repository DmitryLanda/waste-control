<?php

declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Domain\Account;
use App\Account\Domain\AccountId;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use App\Account\Http\Transaction;
use Exception;

class TransactionService
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository
    ) {}

    /**
     * @throws Exception
     */
    public function registerTransaction(string $accountId, Transaction $transaction): void
    {
        $account = $this->retrieveAccount($accountId);
        if ($transaction->isPositive()) {
            $account->addMoney(abs($transaction->getAmount()), $transaction->getComment());
        } else {
            $account->spendMoney(abs($transaction->getAmount()), $transaction->getComment());
        }

        $this->accountRepository->persist($account);
    }

    /**
     * @throws Exception
     */
    private function retrieveAccount(string $accountId): Account
    {
        $aggregateId = AccountId::fromString($accountId);
        $account = $this->accountRepository->retrieveFromSnapshot($aggregateId);
        if (!$account || !$account->isValid()) {
            throw new Exception("Account #$accountId not exists");
        }

        return $account;
    }
}