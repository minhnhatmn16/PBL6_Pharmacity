<?php

namespace App\Repositories;

use App\Models\Supplier;

/**
 * Interface ExampleRepository.
 */
class SupplierRepository extends BaseRepository implements SupplierInterface {
    public function getModel(){
        return Supplier::class;
    }
    public static function getAll($filter){
        $filter = (object) $filter;
        $data = (new self)->model
        ->when(!empty($filter->search), function ($q) use ($filter) {
            $q->where(function ($query) use ($filter) {
                $query->where('supplier_name', 'LIKE', '%' . $filter->search . '%')
                    ->orWhere('contact_person', 'LIKE', '%' . $filter->search . '%')
                    ->orWhere('supplier_address', 'LIKE', '%' . $filter->search . '%')
                    ->orWhere('supplier_phone', 'LIKE', '%' . $filter->search . '%')
                    ->orWhere('supplier_email', 'LIKE', '%' . $filter->search . '%');
            });
        })
            ->when(isset($filter->supplier_is_delete), function ($query) use ($filter) {
                if ($filter->supplier_is_delete !== 'all') {
                    $query->where('suppliers.supplier_is_delete', $filter->supplier_is_delete);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            });

        return $data;
    }

}
