<?php 
namespace App\Services;

use App\Http\Requests\RequestAddImport;
use App\Models\Import;
use App\Models\ImportDetail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\ImportInterface;
use App\Traits\APIResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportService{
    use APIResponse;
    protected ImportInterface $importRepository;
    public function __construct(ImportInterface $importRepository){
        $this->importRepository = $importRepository;
    }
    public function add(RequestAddImport $request){
        DB::beginTransaction();
        try{
            $data = [
                'supplier_id' => $request->supplier_id,
                'import_date' => now(),
                'import_total_amount' => 0.00,
                'import_created_at' => now(),
            ];
            $import = Import::create($data);
            $importTotal = 0;
            $importDetails = [];
            foreach($request->import_details as $importDetail){
                $detail = [
                    'import_id' => $import->import_id,
                    'product_id' => $importDetail['product_id'],
                    'import_quantity' => $importDetail['import_quantity'],
                    'retaining_quantity'=> $importDetail['import_quantity'],
                    'import_price' => $importDetail['import_price'],
                    'product_total_price' => $importDetail['import_quantity'] * $importDetail['import_price'],
                    'product_expiry_date' => $importDetail['product_expiry_date'],
                    'entry_date' => now(),
                ];
                $product = Product::find($importDetail['product_id']);
                $product->update([
                    'product_quantity' => $product->product_quantity + $importDetail['import_quantity'],
                    'product_updated_at' => now(),
                ]);
                $importTotal += $detail['product_total_price'];
                $import_detail = ImportDetail::create($detail);
                $importDetails[] = $import_detail;
            }
            $import->update(['import_total_amount' => $importTotal,'import_updated_at' => now()]);
            DB::commit();
            $import['import_details'] = $importDetails;
            $data=$import;
            return $this->responseSuccessWithData($data,'Nhập kho thành công!',200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getAll(Request $request){
        try{
            $orderBy = $request->typesort ?? 'import_id';
            switch($orderBy){
                case 'supplier_name':
                    $orderBy = 'supplier_name';
                    break;
                case 'import_total_amount':
                    $orderBy = 'import_total_amount';
                    break;
                case 'new':
                    $orderBy = 'import_id';
                    break;
                case 'import_date':
                    $orderBy = 'import_date';
                    break;
                case 'import_id':
                    $orderBy = 'import_id';
                    break;
                default:
                    $orderBy = 'import_id';
                    break;
            }
            $orderDirection = $request->sortlatest ?? 'true';
            switch($orderDirection){
                case 'true':
                    $orderDirection = 'DESC';
                    break;
                default:
                    $orderDirection = 'ASC';
                    break;
            }
            $filter = (object) [
                'search' => $request->search ?? '',
                'supplier_name'=> $request->supplier_name ?? '',
                'import_date'=> $request->import_date ?? 'all',
                'from_date'=> $request->from_date ?? '',
                'to_date' => $request->to_date ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
            ];
            $imports = $this->importRepository->getAll($filter);
            if(!empty($request->paginate)){
                $imports = $imports->paginate($request->paginate);
            }
            else{
                $imports = $imports->get();
            }
            $data=$imports;
            return $this->responseSuccessWithData($data, "Lấy danh sách nhập kho thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function getImportDetails(Request $request,$id){
        try{
            // $import = Import::find($id);
            $import = $this->importRepository->getAll((object)['import_id' => $id])->first();;
            if(empty($import)){
                return $this->responseError('Không tìm thấy phiếu nhập kho này!');
            }
            // $importDetails =ImportDetail::where('import_id',$id)->get();
            // dd($importDetails);
            $importDetails=$this->importRepository->getImportDetails($id);
            $import['import_details'] = $importDetails;
            $data = $import;
            return $this->responseSuccessWithData($data, "Lấy danh sách chi tiết nhập kho thành công!", 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    // public function update(RequestAddImport $request,$id){
    //     DB::beginTransaction();
    //     try{
    //         $import = Import::find($id);
    //         if(empty($import)){
    //             return $this->responseError('Không tìm thấy phiếu nhập kho này!');
    //         }
    //         $importTotal = 0;
    //         $importDetails = [];
    //         foreach($request->import_details as $importDetail){
    //             $detail = [
    //                 'import_id' => $import->import_id,
    //                 'product_id' => $importDetail['product_id'],
    //                 'import_quantity' => $importDetail['import_quantity'],
    //                 'remaining_quantity'=> $importDetail['import_quantity'],
    //                 'import_price' => $importDetail['import_price'],
    //                 'product_total_price' => $importDetail['import_quantity'] * $importDetail['import_price'],
    //                 'product_expiry_date' => $importDetail['product_expiry_date'],
    //                 'entry_date' => $import->import_date,
    //             ];
    //             $product = Product::find($importDetail['product_id']);
    //             $product->update([
    //                 'product_quantity' => $product->product_quantity + $importDetail['import_quantity'],
    //             ]);
    //             $importTotal += $detail['product_total_price'];
    //             $import_detail = ImportDetail::create($detail);
    //             $importDetails[] = $import_detail;
    //         }
    //         $import->update(['import_total_amount' => $importTotal]);
    //         DB::commit();
    //         $data = [
    //             'import' => $import,
    //             'import_details' => $importDetails,
    //         ];
    //         return $this->responseSuccessWithData($data,'Nhập kho thành công!',200);
    //     }
    //     catch(Throwable $e){
    //         DB::rollBack();
    //         return $this->responseError($e->getMessage());
    //     }
    // }
}