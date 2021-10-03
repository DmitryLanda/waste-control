<?php

namespace App\Controller;

use App\Services\StatisticService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    #[Route('/stats/today', name: 'stats.today')]
    public function today(StatisticService $service)
    {
        $start = (new DateTime())->setTime(0, 0, 0);
        $end = (new DateTime())->setTime(23, 59, 59);

        return $this->json($service->statsForPeriodPerCategory($start, $end));
    }

    #[Route('/stats/week', name: 'stats.week')]
    public function week(StatisticService $service)
    {
        $start = (new DateTime('last monday'))->setTime(0, 0, 0);
        $end = (new DateTime('this sunday'))->setTime(23, 59, 59);

        return $this->json($service->statsForPeriodPerCategory($start, $end));
    }

    #[Route('/stats/month', name: 'stats.month')]
    public function month(StatisticService $service)
    {
        $start = (new DateTime('first day of this month'))->setTime(0, 0, 0);
        $end = (new DateTime('last day of this month'))->setTime(23, 59, 59);

        return $this->json($service->statsForPeriodPerCategory($start, $end));
    }

    #[Route('/stats/year', name: 'stats.year')]
    public function year(StatisticService $service)
    {
        $year = (new DateTime())->format('Y');
        $start = (new DateTime("$year-01-01"))->setTime(0, 0, 0);
        $end = (new DateTime())->setTime(23, 59, 59);

        return $this->json($service->statsForPeriodPerMonth($start, $end));
    }
}
