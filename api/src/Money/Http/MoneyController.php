<?php

declare(strict_types=1);

namespace App\Money\Http;

use App\Money\Application\AccountService;
use App\Money\Domain\Account;
use App\Money\Domain\AccountId;
use App\Money\Domain\Repository\AccountRepositoryInterface;
use EventSauce\EventSourcing\InMemoryMessageRepository;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/account')]
class MoneyController extends AbstractController
{
    public function __construct(private AccountService $service)
    {}

    #[Route('/{id}/transactions', name: 'account.transactions.add', methods: ['POST'])]
    #[ParamConverter('transaction', converter: 'json_converter')]
    public function addTransaction(string $id, Transaction $transaction): Response
    {
        $this->service->registerTransaction($id, $transaction);

        return $this->json(['result' => 'ok'], Response::HTTP_CREATED);
    }
}
