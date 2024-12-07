<?php 
namespace App\Services;

use App\Http\Requests\RequestAddReceiverAddress;
use App\Http\Requests\RequestUserUpdateAddress;
use App\Models\Order;
use App\Models\ReceiverAddress;
use App\Models\User;
use App\Repositories\ReceiverAddressInterface;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReceiverAddressService
{
    use APIResponse;
    protected ReceiverAddressInterface $receiverAddressRepository;
    public function __construct(ReceiverAddressInterface $receiverAddressRepository)
    {
        $this->receiverAddressRepository = $receiverAddressRepository;
    }
    public function add(RequestAddReceiverAddress $request)
    {
        DB::beginTransaction();
        try{
            $id_user = auth('user_api')->user()->user_id;
            $data =array_merge($request->all(),['user_id'=>$id_user,'receiver_created_at'=>now()]);
            $receiverAddress= ReceiverAddress::create($data);
            DB::commit();
            $data=$this->receiverAddressRepository->getAll((object)['receiver_address_id'=>$receiverAddress->receiver_address_id])->first();
            return $this->responseSuccessWithData($data,'Thêm địa chỉ nhận hàng thành công!', 201);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getAddress(Request $request,$id){
        try{
            $user_id = auth('user_api')->user()->user_id;
            $user= User::find($user_id);
            if($user){
                $data=$this->receiverAddressRepository->getAll((object)['receiver_address_id'=>$id,'user_id'=>$user_id])->first();
                if($data){
                    return $this->responseSuccessWithData($data,'Lấy địa chỉ nhận hàng thành công!', 200);
                }
                else{
                    return $this->responseError('Không tìm thấy địa chỉ nhận hàng!',400);
                }
            }
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function update(RequestUserUpdateAddress $request,$id){
        DB::beginTransaction();
        try{
            $user_id = auth('user_api')->user()->user_id;
            // $receiver_address = ReceiverAddress::where('receiver_address_id',$id)->where('user_id',$user_id)->first();
            $receiver_address = ReceiverAddress::where('receiver_address_id',$id)
                                               ->where('user_id',$user_id)
                                               ->where('receiver_addresses_delete',0)->first();
            if($receiver_address){
                $receiver_address->update($request->all(),[
                    'receiver_updated_at'=>now()
                ]);
                DB::commit();
                $data = $this->receiverAddressRepository->getAll((object)['receiver_address_id' => $id, 'user_id' => $user_id])->first();
                return $this->responseSuccessWithData($data,'Cập nhật địa chỉ nhận hàng thành công!', 200);
            }
            else{
                return $this->responseError('Không tìm thấy địa chỉ nhận hàng!',400);
            }
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getAll(Request $request){
        try{
            $orderBy = $request->typesort ?? 'receiver_address_id';
            switch ($orderBy) {
                case 'receiver_name':
                    $orderBy = 'receiver_name';
                    break;
                case 'receiver_phone':
                    $orderBy = 'receiver_phone';
                    break;
                case 'new':
                    $orderBy = "receiver_address_id";
                    break;
                default:
                    $orderBy = 'receiver_address_id';
                    break;
            }
            $orderDirection = $request->sortlatest ?? 'true';
            switch ($orderDirection) {
                case 'true':
                    $orderDirection = 'DESC';
                    break;
                default:
                    $orderDirection = 'ASC';
                    break;
            }
            $filter = [
                'search' => $request->search ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
                'user_id' => auth('user_api')->user()->user_id
            ];
            $receiver_address = $this->receiverAddressRepository->getAll($filter);
            if($request->paginate){
                $receiver_address = $receiver_address->paginate($request->paginate);
            }
            else{
                $receiver_address = $receiver_address->get();
            }

            if(!empty($receiver_address)){
                $data=$receiver_address;
                return $this->responseSuccessWithData($data,'Lấy tất cả địa chỉ nhận hàng thành công!', 200);
            }
            else{
                return $this->responseError('Không tìm thấy địa chỉ nhận hàng!',404);
            }
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function delete(Request $request,$id){
        DB::beginTransaction();
        try{
            $user_id = auth('user_api')->user()->user_id;
            $receiver_address = ReceiverAddress::where('receiver_address_id',$id)->where('user_id',$user_id)->first();
            if($receiver_address){
                // $order=Order::where('receiver_address_id',$id)->first();
                // if($order){
                //     return $this->responseError('Địa chỉ nhận hàng đang được sử dụng không được xoá!');
                // }
                // $receiver_address->delete();
                // DB::commit();
                // return $this->responseSuccess('Xóa địa chỉ nhận hàng thành công!', 200);
                if ($receiver_address->receiver_addresses_delete == 0)
                {
                    $receiver_address->receiver_addresses_delete = 1;
                    $receiver_address->save();
                    DB::commit();
                    return $this->responseSuccess('Xóa địa chỉ nhận hàng thành công!', 200);
                } else {
                    return $this->responseError('Không tìm thấy địa chỉ nhận hàng!');
                }
            }
            else{
                return $this->responseError('Không tìm thấy địa chỉ nhận hàng!');
            }
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());  
        }
    }

}