<?php

declare(strict_types=1);

namespace App\Account\Application;

use App\Account\Application\Dto\AccountResponse;
use App\Account\Domain\Account;
use App\Account\Domain\AccountId;
use App\Account\Domain\Repository\AccountRepositoryInterface;
use App\Account\Domain\Repository\UserAccountRepositoryInterface;

class AccountService
{
    public function __construct(
        private AccountRepositoryInterface     $accountRepository,
        private UserAccountRepositoryInterface $userAccountRepository
    ) {
    }

    public function createNewAccount(string $userId, string $name): string
    {
        $aggregateId = AccountId::generate();
        $account = Account::create($aggregateId, $name, $userId);
        $this->accountRepository->persist($account);

        return $aggregateId->toString();
    }

    /**
     * @return array<AccountResponse>
     */
    public function findByUserId(string $userId): array
    {
        $accounts = $this->userAccountRepository->findByUserId($userId);
        $result = [];
        foreach ($accounts as $account) {
            $result[] = AccountResponse::fromArray($account);
        }

        return $result;
    }
}