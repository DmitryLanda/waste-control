<?php

declare(strict_types=1);

namespace App\Transaction\Application;

use App\Shared\Dto\Pagination;
use App\Transaction\Application\Dto\TransactionResponse;
use App\Transaction\Domain\Repository\TransactionRepositoryInterface;
use App\Transaction\Domain\Transaction;

class TransactionService
{

    public function __construct(private TransactionRepositoryInterface $transactionRepository)
    {
    }

    /**
     * @return array<TransactionResponse>
     */
    public function searchTransactions(string $accountId, Pagination $pagination): array
    {
        return array_map(static function (Transaction $transaction): TransactionResponse {
            return TransactionResponse::fromDomain($transaction);
        }, $this->transactionRepository->findByAccountId($accountId, $pagination->getPage(), $pagination->getLimit()));
    }
}