<?php

namespace App\Repositories;

use App\Models\Import;

class ImportRepository extends BaseRepository implements ImportInterface
{
    public function getModel()
    {
        return Import::class;
    }
    public static function getAll($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model->selectRaw('imports.*,suppliers.supplier_name')
            ->leftJoin('suppliers', 'imports.supplier_id', 'suppliers.supplier_id')
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('supplier_name', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('import_total_amount', 'LIKE', '%' . $filter->search . '%');
                });
            })
            ->when(!empty($filter->supplier_name), function ($query) use ($filter) {
                return $query->where('suppliers.supplier_name', '=', $filter->supplier_name);
            })
            ->when(isset($filter->import_date), function ($query) use ($filter) {
                if ($filter->import_date !== 'all') {
                    $query->whereDate('import_date', $filter->import_date);
                }
            })
            ->when(!empty($filter->from_date) || !empty($filter->to_date), function ($query) use ($filter) {
                if (!empty($filter->from_date) && empty($filter->to_date)) {
                    return $query->whereDate('import_date', '>=', $filter->from_date);
                } elseif (empty($filter->from_date) && !empty($filter->to_date)) {
                    return $query->whereDate('import_date', '<=', $filter->to_date);
                } else {
                    return $query->whereBetween('import_date', [$filter->from_date, $filter->to_date]);
                }
            })
            ->when(!empty($filter->import_id), function ($query) use ($filter) {
                return $query->where('import_id', $filter->import_id);
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            });
        return $data;
    }
    public static function getImportDetails($id)
    {
        $importDetail = (new self)->model->selectRaw('import_details.*,products.*')
            ->join('import_details', 'imports.import_id', '=', 'import_details.import_id')
            ->join('products', 'import_details.product_id', '=', 'products.product_id')
            ->where('imports.import_id', $id)
            ->select('import_details.*', 'products.product_name')
            ->get();
        return $importDetail;
    }
}
