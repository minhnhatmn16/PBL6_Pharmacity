<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreateSupplier;
use App\Http\Requests\RequestDeleteSupplier;
use App\Http\Requests\RequestUpdateSupplier;
use App\Models\Supplier;

use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;
    public function __construct(SupplierService $supplierService){
        $this->supplierService = $supplierService;
    }
    public function add(RequestCreateSupplier $request){
        return $this->supplierService->add($request);
    }
    public function update(RequestUpdateSupplier $request,$id){
         return $this->supplierService->update($request,$id);
    }
    public function get(Request $request,$id){
        return $this->supplierService->get($request, $id);
    }
    public function delete(RequestDeleteSupplier $request,$id){
        return $this->supplierService->delete($request, $id);
    }
    public function getAll(Request $request){
        return $this->supplierService->getAll($request);
    }
    public function getNameSupplier(Request $request){
        return $this->supplierService->getNameSupplier($request);
    }
}
