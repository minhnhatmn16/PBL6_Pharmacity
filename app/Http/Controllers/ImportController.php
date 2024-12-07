<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestAddImport;
use App\Services\ImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected ImportService $importService;
    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }
    public function add(RequestAddImport $request){
        return $this->importService->add($request);
    }
    public function getAll(Request $request){
        return $this->importService->getAll($request);
    }
    public function getImportDetails(Request $request,$id){
        return $this->importService->getImportDetails($request,$id);
    }
    // public function update(RequestAddImport $request,$id){
    //     return $this->importService->update($request,$id);
    // }
}
