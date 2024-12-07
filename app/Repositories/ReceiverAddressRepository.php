<?php 
namespace App\Repositories;

use App\Models\ReceiverAddress;

class ReceiverAddressRepository extends BaseRepository implements ReceiverAddressInterface
{
    public function getModel()
    {
        return ReceiverAddress::class;
    }
    public function getAll($filter){
        $filter = (object) $filter;
        $data = (new self)->model->join('provinces', 'receiver_addresses.province_id', '=', 'provinces.id')
            ->join('districts', 'receiver_addresses.district_id', '=', 'districts.id')
            ->join('wards', 'receiver_addresses.ward_id', '=', 'wards.id')
            ->select(
                'receiver_addresses.*',
                'provinces.name as province_name',
                'districts.name as district_name',
                'wards.name as ward_name'
            )
            ->where('receiver_addresses.receiver_addresses_delete', 0)
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('receiver_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('receiver_phone', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('province_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('district_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('ward_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('receiver_address', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(!empty($filter->user_id), function ($query) use ($filter) {
                return $query->where('user_id', '=', $filter->user_id);
            })
            ->when(!empty($filter->receiver_address_id), function ($query) use ($filter) {
                return $query->where('receiver_address_id', '=', $filter->receiver_address_id);
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            });
        return $data;
    }
}