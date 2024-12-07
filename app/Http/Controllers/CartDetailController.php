<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\CartDetail;
use App\Services\CartDetailService;

use App\Http\Requests\RequestAddCartDetail;
use App\Http\Requests\RequestDeleteManyCartDetail;

class CartDetailController extends Controller
{
    protected CartDetailService $cartdetailService;
    public function __construct(CartDetailService $cartdetailService){
        $this->cartdetailService = $cartdetailService;
    }

    public function get(Request $request){
        return $this->cartdetailService->get($request);
    }
    public function add(RequestAddCartDetail $request){
        return $this->cartdetailService->add($request);
    }

    public function update(RequestAddCartDetail $request){
        return $this->cartdetailService->update($request);
    }

    public function delete(Request $request, $id){
        return $this->cartdetailService->delete($request, $id);
    }

    public function deleteMany(RequestDeleteManyCartDetail $request){
        return $this->cartdetailService->deleteMany($request);
    }
}
