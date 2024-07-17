<?php

namespace App\Controller;

use App\Repository\DailyResultRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Chartjs\Model\Chart;

class ChartjsController extends AbstractController
{
    #[Route('/chartjs', name: 'app_chartjs')]
    public function index(DailyResultRepository $dailyResultRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $dailyResults = $dailyResultRepository->findAll();
        $labels = [];
        $data = [];

        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getDate()->format('d/m/Y');
            $data[] = $dailyResult->getValue();
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);
        $chart->setOptions([]);

        return $this->render('chartjs/index.html.twig', [
            'controller_name' => 'ChartjsController',
            'chart' => $chart,
        ]);

    }
}
