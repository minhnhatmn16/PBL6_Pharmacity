<?php

namespace App\Http\Controllers;

use App\Services\DeliveryService;
use Illuminate\Http\Request;
use App\Http\Requests\RequestAddDeliveryMethod;
use App\Http\Requests\RequestUpdateDeliveryMethod;
class DeliveryController extends Controller
{
    protected DeliveryService $deliveryService;
    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }
       public function add(RequestAddDeliveryMethod $request)
    {
        return $this->deliveryService->add($request);
    }
    public function getDeliveryMethod(Request $request, $id)
    {
        return $this->deliveryService->getDeliveryMethod($request, $id);
    }
    public function update(RequestUpdateDeliveryMethod $request, $id)
    {
        return $this->deliveryService->update($request, $id);
    }
    public function delete(Request $request, $id)
    {
        return $this->deliveryService->delete($request, $id);
    }
    public function getAllByAdmin(Request $request)
    {
        return $this->deliveryService->getAllDeliveryMethodByAdmin($request);
    }
    public function getAll(Request $request)
    {
        return $this->deliveryService->getAllDeliveryMethodByUser($request);
    }
    public function manageDelivery(Request $request)
    {
        return $this->deliveryService->getAll($request);
    }
    public function updateStatus(Request $request, $id)
    {
        return $this->deliveryService->updateStatus($request, $id);
    }
    public function getDeliveryDetail(Request $request, $id)
    {
        return $this->deliveryService->getDelivery($request, $id);
    }

}
