<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreateBrand;
use App\Http\Requests\RequestDeleteBrand;
use App\Http\Requests\RequestUpdateBrand;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected BrandService $brandService;
    public function __construct(BrandService $brandService){
        $this->brandService = $brandService;
    }
    public function add(RequestCreateBrand $request){
        return $this->brandService->add($request);
    }
    public function update(RequestUpdateBrand $request,$id){
         return $this->brandService->update($request,$id);
    }
    public function get(Request $request,$id){
        return $this->brandService->get($request, $id);
    }
    public function delete(RequestDeleteBrand $request,$id){
        return $this->brandService->delete($request, $id);
    }
    public function getAll(Request $request){
        return $this->brandService->getAll($request);
    }
    public function getNameBrand(Request $request){
        return $this->brandService->getNameBrand($request);
    }
    public function getAllByAdmin(Request $request){
        return $this->brandService->getAllByAdmin($request);
    }
    public function getBySlug(Request $request,$slug){
        return $this->brandService->getBySlug($request, $slug);
    }
}
