<?php

declare(strict_types=1);

namespace App\Statistic\Http;

use App\Shared\Dto\Pagination;
use App\Statistic\Application\StatisticService;
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

    #[Route('/{accountId}/statistic/total', name: 'account.statistic.total', methods: ['GET'])]
    public function getAccountStatistic(string $accountId): Response
    {
        return $this->json(
            $this->service->getAccountStats($accountId),
            Response::HTTP_OK
        );
    }


    #[Route('/{accountId}/statistic/categories', name: 'account.statistic.categories', methods: ['GET'])]
    #[ParamConverter('pagination', converter: 'query_converter')]
    public function getTopCategories(string $accountId, Pagination $pagination): Response
    {
        return $this->json(
            $this->service->getTopCategories($accountId, $pagination),
            Response::HTTP_OK
        );
    }
}
