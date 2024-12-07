<?php

namespace App\Services;
use App\Traits\APIResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Throwable;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ImageService
{
    use APIResponse;
    public function uploadImage(Request $request)
    {
        try {
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $image = $request->file('image');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/avatar/image',
                    'resource_type' => 'auto',
                ]);
                $url = $uploadFile->getSecurePath();
                $data = ['url' => $url];
                return $this->responseSuccessWithData($data, 'Tải hình ảnh thành công', 200);
            }
            return $this->responseError('Vui lòng chọn ảnh hợp lệ để tải lên');
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
