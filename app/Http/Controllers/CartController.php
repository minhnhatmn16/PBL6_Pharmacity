<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Services\CartService;

use App\Http\Requests\RequestAddCartDetail;
use App\Http\Requests\RequestDeleteManyCartDetail;

class CartController extends Controller
{
    protected CartService $cartService;
    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    public function get(Request $request){
        return $this->cartService->get($request);
    }
    public function add(RequestAddCartDetail $request){
        return $this->cartService->add($request);
    }

    public function update(RequestAddCartDetail $request){
        return $this->cartService->update($request);
    }

    public function delete(Request $request, $id){
        return $this->cartService->delete($request, $id);
    }

    public function deleteMany(RequestDeleteManyCartDetail $request){
        return $this->cartService->deleteMany($request);
    }
}
