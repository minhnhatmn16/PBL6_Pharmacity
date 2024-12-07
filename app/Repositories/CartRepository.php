<?php
namespace App\Repositories;
use App\Models\Cart;
/**
 * Interface ExampleRepository.
 */
class CartRepository extends BaseRepository implements CartInterface {
    public function getModel(){
        return Cart::class;
    }
    
}