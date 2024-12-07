<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    protected StatisticService $statisticService;
    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }
    public function getRevenue(Request $request)
    {
        return $this->statisticService->getRevenue($request);
    }
    public function getOrders(Request $request)
    {
        return $this->statisticService->getOrders($request);
    }
    public function getProfit(Request $request)
    {
        return $this->statisticService->getProfitRevenue($request);
    }
    public function getOverview(Request $request){
        return $this->statisticService->getOverview($request);
    }
    public function getTopProduct(Request $request){
        return $this->statisticService->getTopProduct($request);
    }
}
