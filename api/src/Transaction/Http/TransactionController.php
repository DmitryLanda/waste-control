<?php

declare(strict_types=1);

namespace App\Transaction\Http;

use App\Transaction\Application\Dto\SearchTransactions;
use App\Transaction\Application\TransactionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    #[ParamConverter('criteria', converter: 'query_converter')]
    public function showTransaction(string $accountId, SearchTransactions $criteria): Response
    {
        return $this->json(
            $this->service->searchTransactions($accountId, $criteria),
            Response::HTTP_OK
        );
    }
}
