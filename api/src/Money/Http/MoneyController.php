<?php

declare(strict_types=1);

namespace App\Money\Http;

use App\Money\Application\AccountService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounts')]
class MoneyController extends AbstractController
{
    public function __construct(private AccountService $service)
    {
    }

    #[Route('/{id}/transactions', name: 'account.transactions.add', methods: ['POST'])]
    #[ParamConverter('transaction', converter: 'json_converter')]
    public function addTransaction(string $id, Transaction $transaction): Response
    {
        try {
            $this->service->registerTransaction($id, $transaction);
        } catch (Exception $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->json(['result' => 'ok'], Response::HTTP_CREATED);
    }
}
