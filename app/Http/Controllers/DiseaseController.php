<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiseaseService;
use App\Http\Requests\RequestDiseaseAdd;
use App\Http\Requests\RequestAddDiseaseCategory;
class DiseaseController extends Controller
{
    protected DiseaseService $diseaseService;
    public function __construct(DiseaseService $diseaseService){
        $this->diseaseService = $diseaseService;
    }

    public function add(RequestDiseaseAdd $request){
        return $this->diseaseService->add($request);
    }

    public function getAll(Request $request){
        return $this->diseaseService->getAll($request);
    }

    public function get(Request $request, $id){
        return $this->diseaseService->get($request, $id);
    }

    public function update(RequestDiseaseAdd $request, $id){
        return $this->diseaseService->update($request, $id);
    }

    public function addDiseaseCategory(Request $request){
        return $this->diseaseService->addDiseaseCategory($request);
    }

    public function deleteDiseaseCategory(Request $request){
        return $this->diseaseService->deleteDiseaseCategory($request);
    }

    public function getDiseaseCategory(Request $request, $id){
        return $this->diseaseService->getDiseaseCategory($request, $id);
    }

    public function getDiseaseUser(Request $request){
        return $this->diseaseService->getDiseaseUser($request);
    }

    public function searchDisease(Request $request) {
        return $this->diseaseService->searchDisease($request);
    }
    
    public function getCategoryDisease($id){
        return $this->diseaseService->getCategoryDisease($id);
    }
    
    public function deleteDisease($id){
        return $this->diseaseService->deleteDisease($id);
    }
}
