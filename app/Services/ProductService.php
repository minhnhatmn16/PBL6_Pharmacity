<?php
namespace App\Services;

use App\Http\Requests\RequestAddProduct;
use App\Http\Requests\RequestUpdateProduct;
use App\Http\Requests\RequestDeleteManyProduct;
use App\Http\Requests\RequestDeleteProduct;
use App\Jobs\UploadImage;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Repositories\ProductInterface;
use App\Traits\APIResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductService{
    use APIResponse;
    protected ProductInterface $productRepository;
    public function __construct(ProductInterface $productRepository){
        $this->productRepository = $productRepository;
    }
    public function get(Request $request,$id){
        try{
            // $product = Product::find($id);
            $product =$this->productRepository->getAll((object)['product_id'=>$id])->first();
            if(empty($product)){
                return $this->responseError("Sản phẩm không tồn tại!",404);
            }
            $category_id = $product->category_id;
            $product['same_category']=$this->productRepository->getAll((object)['category_id' => $category_id,'product_is_delete'=>'0'])->where('product_id','!=',$id)->get();
            
            $data=$product;
            return $this->responseSuccessWithData($data, "Lấy sản phẩm thành công!");
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function getAll($request){
        try {
            $orderBy = $request->typesort ?? 'products.product_id';
            switch ($orderBy) {
                case 'product_name':
                    $orderBy = 'products.product_name';
                    break;
                case 'product_price':
                    $orderBy = 'products.product_price';
                    break;
                case 'product_sold':
                    $orderBy = 'products.product_sold';
                    break;
                case 'product_quantity':
                    $orderBy = 'products.product_quantity';
                    break;
                case 'new':
                    $orderBy = 'products.product_id';
                    break;
                default:
                    $orderBy = 'products.product_id';
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
            $filter = (object) [
                'search' => $request->search ?? '',
                'category_name' => $request->category_name ?? '',
                'category_parent_name' => $request->category_parent_name ?? '',
                'category_id' => $request->category_id ?? '',
                'brand_names' => $request->brand_names ?? [],
                'brand_id' => $request->brand_id ?? '',
                'price_from' => $request->price_from ?? '',
                'price_to' => $request->price_to ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
                'product_is_delete' =>0 ,
            ];
            $products = $this->productRepository->getAll($filter);
            if (!empty($request->paginate)) {
                $data= $products->paginate($request->paginate);
            } else {
                $data= $products->get();
            }
            return $this->responseSuccessWithData($data, 'Danh sách sản phẩm!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getAllByAdmin(Request $request)
    {
        try {
            $orderBy = $request->typesort ?? 'products.product_id';
            switch ($orderBy) {
                case 'product_name':
                    $orderBy = 'products.product_name';
                    break;
                case 'product_price':
                    $orderBy = 'products.product_price';
                    break;
                case 'product_sold':
                    $orderBy = 'products.product_sold';
                    break;
                case 'product_quantity':
                    $orderBy = 'products.product_quantity';
                    break;
                case 'new':
                    $orderBy = 'products.product_id';
                    break;
                default:
                    $orderBy = 'products.product_id';
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
            $filter = (object) [
                'search' => $request->search ?? '',
                'category_name' => $request->category_name ?? '',
                'category_parent_name' => $request->category_parent_name ?? '',
                'category_id' => $request->category_id ?? '',
                'brand_names' => $request->brand_names ?? [],
                'brand_id' => $request->brand_id ?? '',
                'price_from' => $request->price_from ?? '',
                'price_to' => $request->price_to ?? '',
                'orderBy' => $orderBy,
                'orderDirection' => $orderDirection,
                'product_is_delete' => $request->product_is_delete ?? 'all',
            ];
            $products = $this->productRepository->getAll($filter);
            if (!empty($request->paginate)) {
                $data= $products->paginate($request->paginate);
            } else {
                $data= $products->get();
            }
            return $this->responseSuccessWithData($data, 'Danh sách sản phẩm!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }


    public function add(RequestAddProduct $request){
        DB::beginTransaction();
        try{
            $data = $request->all();
            $imageUrls = [];
            if ($request->hasFile('product_images')) {
                $files = $request->file('product_images');
                if (!is_array($files)) {
                    // Nếu chỉ là một file, chuyển nó thành mảng
                    $files = [$files];
                }
                foreach ($files as $file) {
                    $name = time() . $file->getClientOriginalName();
                    $filePath = 'product_image/' . $name;

                    // Upload file to S3 và gán vào biến riêng $uploadSuccess
                    $uploadSuccess = Storage::disk('s3')->put($filePath, file_get_contents($file));

                    // Kiểm tra nếu upload thành công
                    if ($uploadSuccess) {
                        // Set ACL to public-read
                        Storage::disk('s3')->setVisibility($filePath, 'public');

                        // Lấy URL của file
                        $url = Storage::disk('s3')->url($filePath);

                        // Thêm URL vào mảng $imageUrls
                        $imageUrls[] = $url;
                    }
                }

                $data['product_images'] = $imageUrls;
                // $data['product_images'] = json_encode($imageUrls, JSON_UNESCAPED_SLASHES);
            }
            $data['product_created_at'] = now();
            $product = Product::create($data);
            DB::commit();
            $data = $product;
            return $this->responseSuccessWithData($data, 'Thêm sản phẩm mới thành công!', 201);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    //update when image upload AWS S3
    public function update(RequestUpdateProduct $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if (empty($product)) {
                return $this->responseError("Sản phẩm không tồn tại!");
            }
            $imageUrls = [];
            if ($request->hasFile('product_images')) {
                if ($product->product_images) {
                    // $urlImages=json_decode($product->product_images,true);
                    $urlImages = $product->product_images;
                    // Duyệt qua từng URL trong mảng, kể cả nếu chỉ có một phần tử
                    foreach ($urlImages as $url) {
                        // Lấy tên file từ URL (ví dụ: 172682205420240819041436-1-P28111_1.jpg)
                        $key_image = basename($url);
                        // Xóa file khỏi S3
                        Storage::disk('s3')->delete('product_image/' . $key_image);
                    }
                }
                $files = $request->file('product_images');
                if (!is_array($files)) {
                    // Nếu chỉ là một file, chuyển nó thành mảng
                    $files = [$files];
                }
                foreach ($files as $file) {
                    $name = time() . $file->getClientOriginalName();
                    $filePath = 'product_image/' . $name;

                    // Upload file to S3 và gán vào biến riêng $uploadSuccess
                    $uploadSuccess = Storage::disk('s3')->put($filePath, file_get_contents($file));

                    // Kiểm tra nếu upload thành công
                    if ($uploadSuccess) {
                        // Set ACL to public-read
                        Storage::disk('s3')->setVisibility($filePath, 'public');

                        // Lấy URL của file
                        $url = Storage::disk('s3')->url($filePath);

                        // Thêm URL vào mảng $imageUrls
                        $imageUrls[] = $url;
                    }
                }
                $data = array_merge($request->all(), ['product_images' => $imageUrls, 'product_updated_at' => now()]);  
                $product->update($data);
            } else {
                $request['product_images'] = $product->product_images;
                $product->update($request->all(), ['product_updated_at' => now()]);
            }
            DB::commit();
            $data=$product;
            return $this->responseSuccessWithData($data, "Cập nhật sản phẩm thành công!");
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function delete(RequestDeleteProduct $request, $id){
        DB::beginTransaction();
        try{
            $product = Product::find($id);
            if(empty($product)){
                return $this->responseError("Sản phẩm không tồn tại!", 404);
            }
            //kiểm tra xem product đang nằm trong đơn hàng nào hay không
            $productExist=OrderDetail::where('product_id',$id)->first();
            if($productExist){
                return $this->responseError("Sản phẩm đang nằm trong đơn hàng, không thể xoá!");
            }
            $product->update(['product_is_delete' => $request->product_is_delete, 'product_updated_at' => now()]);
            DB::commit();
            $request->product_is_delete == 1 ? $message = "Xoá sản phẩm thành công!" : $message = "Khôi phục sản phẩm thành công!";
            return $this->responseSuccess($message, 200);
        }
        catch(Throwable $e){
            DB::rollback();
            return $this->responseError($e->getMessage());
        }
    }
    public function deleteMany(RequestDeleteManyProduct $request){
        DB::beginTransaction();
        try{
            $ids_product = $request->ids_product;
            $products = Product::whereIn('product_id', $ids_product)->get();
            if($products->isEmpty()){
                return $this->responseError("Không tìm thấy sản phẩm!");
            }
            foreach($products as $index => $product){
                $product->update(['product_is_delete' => $request->product_is_delete, 'product_updated_at' => now()]);
            }
            DB::commit();
            $request->product_is_delete == 1 ? $message = "Xoá các sản phẩm thành công!" : $message = "Khôi phục các sản phẩm thành công!";
            return $this->responseSuccess($message, 200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getNameProduct(Request $request){
        try{
            $products = Product::where('product_is_delete','0')->select('product_id','product_name');
            if($request->paginate){
                $products = $products->paginate($request->paginate);
            }
            else{
                $products = $products->get();
            }
            $data=$products;
            return $this->responseSuccessWithData($data, 'Danh sách sản phẩm!', 200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function getBySlug(Request $request, $slug){
        try{
            $product = Product::where('product_slug',$slug)->first();
            if(empty($product)){
                return $this->responseError("Sản phẩm không tồn tại!",404);
            }
            $id=$product->product_id;
            $product = $this->productRepository->getAll((object)['product_id' => $id])->first();
            $category_id = $product->category_id;
            $product['same_category']=$this->productRepository->getAll((object)['category_id' => $category_id,'product_is_delete'=>'0'])->where('product_id','!=',$id)->get();
            $data = $product;
            return $this->responseSuccessWithData($data, "Lấy sản phẩm thành công!");
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
  

}