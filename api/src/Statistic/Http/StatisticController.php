<?php

declare(strict_types=1);

namespace App\Statistic\Http;

use App\Statistic\Application\Dto\SearchCriteria;
use App\Statistic\Application\StatisticService;
use App\Transaction\Application\Dto\SearchTransactions;
use App\Transaction\Application\TransactionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accounts')]
class StatisticController extends AbstractController
{
    public function __construct(private StatisticService $service)
    {
    }

    #[Route('/{accountId}/statistic', name: 'account.statistic.total', methods: ['GET'])]
    public function getAccountStatistic(string $accountId): Response
    {
        return $this->json(
            $this->service->getAccountStats($accountId),
            Response::HTTP_OK
        );
    }
}
