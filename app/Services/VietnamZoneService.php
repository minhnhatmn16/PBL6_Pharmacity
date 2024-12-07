<?php

namespace App\Services;

use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\APIResponse;

use Illuminate\Http\Request;
use Throwable;

class VietnamZoneService
{
    use APIResponse;
    public function getProvinces()
    {
        try {
            $data = Province::all();
            return $this->responseSuccessWithData($data,'Lấy dữ liệu tỉnh/thành phố thành công',200);
        } catch (Throwable $e) {
            DB::rollback();
            return $this->responseError($e->getMessage());
        }
    }

    public function getDistrictsByProvinceId($provinceId)
    {
        try {
            $data = District::whereProvinceId($provinceId)->get();
            return $this->responseSuccessWithData($data,'Lấy dữ liệu huyện/quận thành công',200);
        } catch (Throwable $e) {
            DB::rollback();
            return $this->responseError($e->getMessage());
        }
    }

    public function getWardsByDistrictId($districtId)
    {
        try {
            $data = Ward::whereDistrictId($districtId)->get();
            return $this->responseSuccessWithData($data,'Lấy dữ liệu xã/phường/thị trấn thành công',200);
        } catch (Throwable $e) {
            DB::rollback();
            return $this->responseError($e->getMessage());
        }
    }
}
