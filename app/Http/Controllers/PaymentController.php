<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAddPaymentMethod;
use App\Http\Requests\RequestUpdatePaymentMethod;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    //payment-method
    public function add(RequestAddPaymentMethod $request)
    {
        return $this->paymentService->add($request);
    }
    public function getPaymentMethod(Request $request, $id)
    {
        return $this->paymentService->getPaymentMethod($request, $id);
    }
    public function update(RequestUpdatePaymentMethod $request, $id)
    {
        return $this->paymentService->update($request, $id);
    }
    public function delete(Request $request, $id)
    {
        return $this->paymentService->delete($request, $id);
    }
    public function getAllByAdmin(Request $request)
    {
        return $this->paymentService->getAllPaymentMethodByAdmin($request);
    }
    public function getAll(Request $request)
    {
        return $this->paymentService->getAllPaymentMethodByUser($request);

    }
    //payments
    public function managePayment(Request $request){
        return $this->paymentService->getAll($request);
    }
    public function updateStatus(Request $request, $id)
    {
        return $this->paymentService->updateStatus($request, $id);
    }
    public function getPaymentDetail(Request $request, $id)
    {
        return $this->paymentService->getPayment($request, $id);
    }
  
    public function handlePayOSWebhook(Request $request)
    {
        return $this->paymentService->handlePayOSWebhook($request);
    }
    //payment vnpay
    public function vnPayReturn(Request $request)
    {
        return $this->paymentService->vnPayReturn($request);
    }
}
