<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAddReceiverAddress;
use App\Http\Requests\RequestUserUpdateAddress;
use App\Models\ReceiverAddress;
use App\Services\ReceiverAddressService;
use Illuminate\Http\Request;

class ReceiverAddressController extends Controller
{
    protected ReceiverAddressService $receiverAddressService;
    public function __construct(ReceiverAddressService $receiverAddressService)
    {
        $this->receiverAddressService = $receiverAddressService;
    }
    public function add(RequestAddReceiverAddress $request)
    {
        return $this->receiverAddressService->add($request);
    }
    public function getAddress(Request $request,$id)
    {
        return $this->receiverAddressService->getAddress($request,$id);
    }
    public function update(RequestUserUpdateAddress $request,$id)
    {
        return $this->receiverAddressService->update($request,$id);
    }
    public function getAll(Request $request)
    {
        return $this->receiverAddressService->getAll($request);
    }
    public function delete(Request $request,$id)
    {
        return $this->receiverAddressService->delete($request,$id);
    }
}
