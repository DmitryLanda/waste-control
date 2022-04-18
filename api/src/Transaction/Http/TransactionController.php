<?php

declare(strict_types=1);

namespace App\Transaction\Http;

use App\Transaction\Application\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounts')]
class TransactionController extends AbstractController
{
    public function __construct(private TransactionService $service)
    {
    }

    #[Route('/{accountId}/transactions', name: 'account.transactions.list', methods: ['GET'])]
    public function showTransaction(string $accountId): Response
    {
        return $this->json(
            $this->service->searchTransactions($accountId),
            Response::HTTP_CREATED
        );
    }
}
