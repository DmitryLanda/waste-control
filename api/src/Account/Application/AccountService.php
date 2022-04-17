<?php

declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Domain\Account;
use App\Account\Domain\AccountId;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use App\Account\Domain\Repository\UserAccountRepositoryInterface;

class AccountService
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private UserAccountRepositoryInterface $userAccountRepository
    ) {}

    public function createNewAccount(string $userId): string
    {
        $aggregateId = AccountId::generate();
        $account = Account::create($aggregateId, $userId);
        $this->accountRepository->persist($account);

        return $aggregateId->toString();
    }

    public function findByUserId(string $userId): array
    {
        $accountIds = $this->userAccountRepository->findByUserId($userId);
        $accounts = [];
        foreach ($accountIds as $accountId) {
            $account = $this->retrieveAccount($accountId);
            if ($account->isValid()) {
                $accounts[] = AccountResponse::fromDomain($account);
            }
        }

        return $accounts;
    }

    private function retrieveAccount(string $accountId): Account
    {
        $aggregateId = AccountId::fromString($accountId);

        return  $this->accountRepository->retrieveFromSnapshot($aggregateId);
    }
}