<?php

declare(strict_types=1);

namespace App\Account\Http;

use App\Account\Application\TransactionService;
use Exception;
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

    #[Route('/{accountId}/transactions', name: 'account.transactions.add', methods: ['POST'])]
    #[ParamConverter('transaction', converter: 'json_converter')]
    public function addTransaction(string $accountId, Transaction $transaction): Response
    {
        try {
            $this->service->registerTransaction($id, $transaction);
        } catch (Exception $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->json(['result' => 'ok'], Response::HTTP_CREATED);
    }
}
