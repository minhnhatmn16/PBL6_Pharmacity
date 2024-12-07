<?php
namespace App\Services;

use App\Http\Requests\RequestDeleteCategory;
use App\Http\Requests\RequestDeleteManyCategory;
use App\Http\Requests\RequestUpdateCategory;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryInterface;
use App\Repositories\ProductInterface;
use App\Traits\APIResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;
use Termwind\Components\BreakLine;
use Throwable;

class CategoryService{
    use APIResponse;
    protected CategoryInterface $categoryRepository;
    protected ProductInterface $productRepository;
    public function __construct(CategoryInterface $categoryRepository,ProductInterface $productRepository){
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }
    public function add($request){
        DB::beginTransaction();
        try{
            $data = $request->all();
            if($request->hasFile('category_thumbnail')){
                $image = $request->file('category_thumbnail');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/thumbnail/category_thumbnail',
                    'resource_type' => 'auto'
                ]);
                $url = $uploadFile->getSecurePath();
                $data['category_thumbnail'] = $url;
                $data['category_created_at'] = now();
            }
            $category = Category::create($data);
            DB::commit();
            $data=$category;
            return $this->responseSuccessWithData($data, 'Thêm category mới thành công!', 201);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function update(RequestUpdateCategory $request,$id){
        DB::beginTransaction();
        try{
           $category = Category::where("category_id",$id)->first();
           if(empty($category)){
               return $this->responseError("Category không tồn tại trong hệ thống",404);
           }
           if($request->hasFile('category_thumbnail')){
               if($category->category_thumbnail){
                    $id_file = explode('.', implode('/', array_slice(explode('/', $category->category_thumbnail), 7)))[0];
                    Cloudinary::destroy($id_file);
               }
               $image = $request->file('category_thumbnail');
               $uploadFile = Cloudinary::upload($image->getRealPath(), [
                   'folder' => 'pbl6_pharmacity/thumbnail/category_thumbnail',
                   'resource_type' => 'auto'
               ]);
               $url = $uploadFile->getSecurePath();
               $data = array_merge($request->all(),['category_thumbnail'=>$url,'category_updated_at'=>now()]);
               $category->update($data);
           }
           else{
                $request['category_thumbnail'] = $category->category_thumbnail;
                $category->update($request->all(),['category_updated_at'=>now()]);
           }
            DB::commit();
            $data=$category;
            return $this->responseSuccessWithData($data, 'Cập nhật category thành công!', 200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function delete(RequestDeleteCategory $request, $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::where("category_id", $id)->first();
            if (empty($category)) {
                return $this->responseError("Không tìm thấy category", 404);
            }
            $category->update(['category_is_delete'=> $request->category_is_delete, 'category_updated_at' => now()]);
            DB::commit();
            $request->category_is_delete == 1 ? $message = "Xoá category thành công!" : $message = "Khôi phục category thành công!";
            return $this->responseSuccess($message ,200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function deleteMany(RequestDeleteManyCategory $request){
        DB::beginTransaction();
        try{
            $ids_category=$request->ids_category;
            $categories = CategoryRepository::getCategory(['ids_category'=> $ids_category])->get();
            if($categories->isEmpty()){
                return $this->responseError("Không tìm thấy category",404);
            }
            foreach($categories as $index => $category){
                $category->update(['category_is_delete'=>$request->category_is_delete,'category_updated_at'=>now()]);
            }
            DB::commit();
            $request->category_is_delete == 1 ? $message = "Xoá các category thành công!" : $message = "Khôi phục các category thành công!";
            return $this->responseSuccess($message,200);
        }
        catch(Throwable $e){
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    public function getListCategories(Request $request){
        $orderBy = $request->typesort ?? 'category_id';
        switch ($orderBy) {
            case 'category_name':
                $orderBy = 'category_name';
                break;
            case 'category_type':
                $orderBy = 'category_type';
                break;
            case 'category_parent_id':
                $orderBy = 'category_parent_id';
                break;
            case 'category_id':
                $orderBy = 'category_id';
                break;
            default:
                $orderBy = 'category_id';
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
            'category_is_delete' => $request->category_is_delete ?? 'all',
            'orderBy' => $orderBy,
            'orderDirection' => $orderDirection,
        ];
        $categories = CategoryRepository::getAll($filter);
        if (!(empty($request->paginate))) {
            $categories = $categories->paginate($request->paginate);
        } else {
            $categories = $categories->get();
        }
        return $categories;
    }
    public function getAll(Request $request)
    {
        try {
            $data=$this->getListCategories($request)->values();
            return $this->responseSuccessWithData($data, "Lấy danh sách category thành công!", 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getNameCategory(Request $request){
        try{
            $categories = Category::where('category_is_delete',0)->whereNotNull('category_parent_id')->select('category_id','category_name');
            if($request->paginate){
                $categories = $categories->paginate($request->paginate);
            }
            else{
                $categories = $categories->get();
            }
            $data=$categories;
            return $this->responseSuccessWithData($data, "Lấy danh sách category thành công!",200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
    public function getCategory(Request $request , $id=null){
        // If an ID is provided, retrieve the specific category and its children
        if ($id !== null) {
            $category = Category::where("category_id", $id)->first();

            if (empty($category)) {
                return $this->responseError("Không tìm thấy category", 404);
            }
            $categoryTree = $this->buildCategoryTree($category);
            return $categoryTree;
        } else {
            $categories = Category::whereNull('category_parent_id')->get();
            $categoryTree = [];
            foreach ($categories as $category) {
                $categoryTree[] = $this->buildCategoryTree($category);
            }
        }
        return $categoryTree;
    }

    public function getCategories(Request $request, $id = null)
    {
        try {
             $data=$this->getCategory($request,$id);
             return $this->responseSuccessWithData($data, "Lấy danh sách category thành công!", 200);
            }
         catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Đệ quy xây dựng cây danh mục.
     * 
     * @param Category $category
     * @return array
     */
    private function buildCategoryTree($category)
    {
        // Lấy các danh mục con của danh mục hiện tại
        $children = Category::where("category_parent_id", $category->category_id)->get();

        // Xây dựng mảng cho danh mục hiện tại
        $categoryTree = [
            'category_id' => $category->category_id,
            'category_name' => $category->category_name,
            'category_type' => $category->category_type,
            'category_thumbnail' => $category->category_thumbnail,
            'category_description' => $category->category_description,
            'category_parent_id' => $category->category_parent_id,
            'category_is_delete' => $category->category_is_delete,
            'children' => []
        ];

        // Đệ quy để thêm các danh mục con
        foreach ($children as $child) {
            $categoryTree['children'][] = $this->buildCategoryTree($child);
        }

        return $categoryTree;
    }
    public function getBySlug(Request $request,$slug){
        try{
            $category = Category::where('category_slug',$slug)->first();
            if(empty($category)){
                return $this->responseError("Không tìm thấy category",404);
            }
            $categories=$this->getCategory($request,$category->category_id);
            if($categories["children"] == []){
                $category_id = $category->category_id;
                $categories['products'] = $this->productRepository->getAll((object)["category_id"=>$category_id,"typesort" => "product_name", "sortlatest" => "true", "product_is_delete"=> "0"])->get()->values();
            }
            else{
                $category_name = $category->category_name;
                if ($category->category_parent_id == null) {
                    $categories['products'] = $this->productRepository->getAll((object)["typesort" => "product_name", "sortlatest" => "true", "product_is_delete", "0"])->get()->values();
                }
                else{
                    $categories['products'] = $this->productRepository->getAll((object)["catergory_parent_name" => $category_name, "product_is_delete", "0"])->get()->values();
                }
                
            }
            $data = $categories;
            return $this->responseSuccessWithData($data, "Lấy thông tin category thành công!",200);
        }
        catch(Throwable $e){
            return $this->responseError($e->getMessage());
        }
    }
}