<?php

namespace App\Http\Controllers;

use App\Services\VietnamZoneService;
use Illuminate\Http\Request;

class VietnamZoneController extends Controller
{
    protected VietnamZoneService $vietnamZoneService;

    public function __construct(VietnamZoneService $vietnamZoneService)
    {
        $this->vietnamZoneService = $vietnamZoneService;
    }

    public function getProvinces()
    {
        return $this->vietnamZoneService->getProvinces();
    }

    public function getDistricts($provinceId)
    {
        return $this->vietnamZoneService->getDistrictsByProvinceId($provinceId);
        
    }

    public function getWards($districtId)
    {
        return $this->vietnamZoneService->getWardsByDistrictId($districtId);
    }
}
