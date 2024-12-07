<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUserBuyProduct;
use App\Http\Requests\RequestUserCheckoutCart;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }
    public function buyNow(RequestUserBuyProduct $request){
        return $this->orderService->buyNow($request);
    }
    public function checkoutCart(RequestUserCheckoutCart $request){
        return $this->orderService->checkoutCart($request);
    }
    public function getOrderDetail(Request $request, $id){
        return $this->orderService->getOrderDetail($request, $id);
    }
    public function cancelOrder(Request $request, $id){
        return $this->orderService->cancelOrder($request, $id);
    }
    public function getOrderHistory(Request $request){
        return $this->orderService->getOrderHistory($request);
    }
    public function getAll(Request $request){
        return $this->orderService->getAll($request);
    }
    public function getDetailOrder(Request $request, $id){
        return $this->orderService->getDetailOrder($request, $id);
    }
    public function updateStatus(Request $request, $id){
        return $this->orderService->updateStatus($request, $id);
    }
    public function getPaymentInfo($orderCode)
    {
        return $this->orderService->getPaymentInfo($orderCode);
    }
    public function cancelPayment($orderCode, Request $request)
    {
        return $this->orderService->cancelPayment($orderCode, $request);
    }
}
