<?php

namespace App\Services;
use App\Traits\APIResponse;

use App\Models\Cart;
use App\Models\Product;

use App\Repositories\CartInterface;
use App\Repositories\CartRepository;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Http\Requests\RequestAddCartDetail;
use App\Http\Requests\RequestDeleteManyCartDetail;
use Throwable;

class CartService
{
    use APIResponse;
    protected CartInterface $cartRepository;
    public function __construct(CartInterface $cartRepository){
        $this->cartRepository = $cartRepository;
    }

    public function get(Request $request){
        try {
            $user_id = auth('user_api')->user()->user_id;
            
            $carts = Cart::where('user_id', $user_id)->get();
            
            if ($carts->isEmpty()) {
                return $this->responseSuccess("Không có sản phẩm nào trong giỏ hàng", 200);
            }

            $cartProducts = [];

            foreach ($carts as $cart) {
                $product_id = $cart->product_id;

                $product = Product::find($product_id);

                if ($product) {
                    $cartProducts[] = [
                        'cart_id' => $cart -> cart_id,
                        'cart_quantity' => $cart -> cart_quantity,
                        'cart_price' => $product -> product_price,
                        'product_id' => $product -> product_id,
                        'product_name' => $product -> product_name,
                        'product_images' => $product -> product_images,
                        'product_quantity' => $product -> product_quantity,
                    ];
                }
            }
            usort($cartProducts, function($a, $b) {
                return $b['cart_id'] - $a['cart_id']; 
            });
            $data=$cartProducts;
            return $this->responseSuccessWithData($data, "Lấy chi tiết giỏ hàng thành công", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function add(RequestAddCartDetail $request){
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user_id = auth('user_api')->user()->user_id;
            if ($data['cart_quantity']<1) 
                return $this->responseError('Số lượng sản phẩm thêm vào phải lớn hơn 0', 400);
            $cart = Cart::where('user_id', $user_id)
                        ->where('product_id', $data['product_id'])
                        ->first();
            
            $product = Product::where('product_id', $data['product_id'])->first();
            
            if ($cart) {
                if ($cart->cart_quantity + $data['cart_quantity'] > $product->product_quantity) {
                    // $cart->cart_quantity = $product->product_quantity;
                    // $cart->save();
                    // DB::commit();
                    $message = "Số lượng sản phẩm vượt quá số lượng trong kho";
                    // return $this->responseSuccessWithData($cart,$message,201);
                    return $this->responseError($message, 400);
                }

                $cart->cart_quantity += $data['cart_quantity'];
                $cart->save();
            } else {
                if ($data['cart_quantity'] > $product->product_quantity) {

                    // $cart = Cart::create([
                    //     'user_id' => $user_id,
                    //     'product_id' => $data['product_id'],
                    //     'cart_quantity' => $product->product_quantity,
                    // ]);
                    // DB::commit();

                    // $message = "Số lượng đặt hàng vượt quá sản phẩm trong kho";
                    // return $this->responseSuccessWithData($cart,$message,201);

                    $message = "Số lượng sản phẩm vượt quá số lượng trong kho";
                    return $this->responseError($message, 400);

                }
                
                $cart = Cart::create([
                    'user_id' => $user_id,
                    'product_id' => $data['product_id'],
                    'cart_quantity' => $data['cart_quantity'],
                ]);
            }
            DB::commit();
            $data=$cart;
            return $this->responseSuccessWithData($data,'Thêm vào giỏ hàng thành công',200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }

    public function update(RequestAddCartDetail $request){
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user_id = auth('user_api')->user()->user_id;
            
            $cart = Cart::where('user_id', $user_id)
                        ->where('product_id', $data['product_id'])
                        ->first();
            
            $product = Product::where('product_id', $data['product_id'])->first();
            if ($data['cart_quantity']<1) {
                $message = "Số lượng sản phẩm trong giỏ hàng phải lớn hơn 0";
                return $this->responseError($message, 400);
            }
            if ($cart) {
                if ($data['cart_quantity'] > $product->product_quantity) {
                    // $cart->cart_quantity = $product->product_quantity;
                    // $cart->save();
                    // DB::commit();
                    // $message = "Số lượng đặt hàng vượt quá sản phẩm trong kho";
                    // return $this->responseSuccessWithData($cart,$message,201);
                    $message = "Số lượng sản phẩm vượt quá sản phẩm trong kho";
                    return $this->responseError($message, 400);
                }

                $cart->cart_quantity = $data['cart_quantity'];
                $cart->save();
            } else {
                $cart = Cart::create([
                    'user_id' => $user_id,
                    'product_id' => $data['product_id'],
                    'cart_quantity' => $data['cart_quantity'],
                ]);
            }
            DB::commit();
            $data=$cart;
            return $this->responseSuccessWithData($data,'Cập nhật sản phẩm thành công',201);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }

    public function delete(Request $request, $id){
        DB::beginTransaction();
        try{
            $cart = Cart::find($id);
            if(empty($cart)){
                return $this->responseError("Sản phẩm không tồn tại!", 404);
            }
            $cart->delete();

            DB::commit();
            $message = "Xóa sản phẩm thành công";
            return $this->responseSuccess($message, 200);
        }
        catch(Throwable $e){
            DB::rollback();
            return $this->responseError($e->getMessage());
        }
    }

    public function deleteMany(RequestDeleteManyCartDetail $request){
        DB::beginTransaction();
        try{
            $ids_cart = $request->ids_cart;
            $carts = Cart::whereIn('cart_id', $ids_cart)->get();
            if($carts->isEmpty()){
                return $this->responseError("Không tìm thấy sản phẩm!");
            }
            foreach($carts as $index => $cart){
                $cart->delete();
            }
            DB::commit();
            $message = "Xóa sản phẩm thành công";
            return $this->responseSuccess($message, 200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
}
