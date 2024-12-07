<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAddProduct;
use App\Http\Requests\RequestUpdateProduct;
use App\Http\Requests\RequestDeleteManyProduct;
use App\Http\Requests\RequestDeleteProduct;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    public function add(RequestAddProduct $request){
        return $this->productService->add($request);
    }
    public function get(Request $request,$id){
        return $this->productService->get($request, $id);
    }
    public function getAll(Request $request){
        return $this->productService->getAll($request);
    }
    public function update(RequestUpdateProduct $request, $id){
        return $this->productService->update($request, $id);
    }
    
    public function delete(RequestDeleteProduct $request, $id){
        return $this->productService->delete($request, $id);
    }
    public function deleteMany(RequestDeleteManyProduct $request){
        return $this->productService->deleteMany($request);
    }
    public function getNameProduct(Request $request){
        return $this->productService->getNameProduct($request);
    }
    public function getAllByAdmin(Request $request){
        return $this->productService->getAllByAdmin($request);
    }
    public function getBySlug(Request $request, $slug){
        return $this->productService->getBySlug($request, $slug);
    }
}
