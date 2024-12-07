<?php

namespace App\Services;
use App\Traits\APIResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Disease;
use App\Models\CategoryDisease;
use App\Models\Category;
use App\Repositories\DiseaseInterface;
use App\Repositories\DiseaseRepository;

use App\Http\Requests\RequestDiseaseAdd;
use App\Http\Requests\RequestAddDiseaseCategory;
use Throwable;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DiseaseService
{
    use APIResponse;
    protected DiseaseInterface $diseaseRepository;
    public function __construct(DiseaseInterface $diseaseRepository){
        $this->diseaseRepository = $diseaseRepository;
    }

    public function add(RequestDiseaseAdd $request){
        DB::beginTransaction();
        try {
            $data = $request->all();

            if($request->hasFile('disease_thumbnail')){
                $image = $request->file('disease_thumbnail');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/avatar/disease_thumbnail',
                    'resource_type' => 'auto',
                ]);
                $url = $uploadFile->getSecurePath();
                $data = array_merge($request->all(), ['disease_thumbnail' => $url]);
            }

            $disease = Disease::create($data);

            DB::commit();
            $data=$disease;
            return $this->responseSuccessWithData($data,'Thêm bệnh mới thành công', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }

    public function getAll(Request $request){
        try {
            $sortBy = $request->input('sort_by', 'disease_id');  
            $sortOrder = $request->input('sort_order', 'asc');   
            $per_page = $request->input('per_page',20);

            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'asc';  
            }

            $disease = Disease::select('disease_id', 'disease_name', 'disease_created_at', 'disease_updated_at')
                                ->orderBy($sortBy, $sortOrder) 
                                ->paginate($per_page);
            $data=$disease;  
            return $this->responseSuccessWithData($data,'Lấy tất cả bệnh thành công', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function get(Request $request, $id){
        try {
            $disease = Disease::find($id);
            if (!$disease) 
                return $this->responseError('Không tìm thấy bệnh', 400);
            else {
                $data=$disease;
                return $this->responseSuccessWithData($data,'Lấy thông tin chi tiết bệnh thành công', 200);
            }
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function update(RequestDiseaseAdd $request, $id){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $disease = Disease::find($id);
            if (!$disease) 
                return $this->responseError('Không tìm thấy bệnh', 404);
            
            $changeImage = false;
            if($request->hasFile('disease_thumbnail')){
                $image = $request->file('disease_thumbnail');
                $uploadFile = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'pbl6_pharmacity/avatar/disease_thumbnail',
                    'resource_type' => 'auto',
                ]);

                // if($disease->disease_thumbnail){
                //     $id_file = explode('.', implode('/', array_slice(explode('/', $disease->disease_thumbnail), 7)))[0];
                //     $cloudinary = new Cloudinary();
                //     $result = $cloudinary->api()->resource($id_file);
                //     if ($result)
                //         Cloudinary::destroy($id_file);
                // }

                $url = $uploadFile->getSecurePath();
                $data = array_merge($request->all(), ['disease_thumbnail' => $url]);
                $changeImage = true;
            } 


            $disease->fill($data);
            $disease->disease_updated_at = now();
            $disease->save();

            //Cập nhật trong database CategoryDisease
            // if ($changeImage) {
                CategoryDisease::where('disease_id', $id)->update([
                    'disease_name' => $disease->disease_name,
                    'disease_thumbnail' => $disease->disease_thumbnail,
                ]);
            // }

            DB::commit();
            $data=$disease;
            return $this->responseSuccessWithData($data, 'Cập nhật bệnh thành công', 200);
        } catch (Throwable $e) {
            DB::rollback();
            return $this->responseError($e->getMessage());
        }
    }


    public function addDiseaseCategory(Request $request){
        DB::beginTransaction();
        try {
            $data = $request->all();
            $category = Category::where('category_id', $data['category_id'])->first();
            $disease = Disease::where('disease_id', $data['disease_id'])->select('disease_name','disease_thumbnail')->first();

            if (!$category) {
                return $this->responseError('Không tìm thấy danh mục bệnh', 400);
            }
            if (!$disease) {
                return $this->responseError('Không tìm thấy bệnh', 400);
            }

            $exists = CategoryDisease::where('category_id', $data['category_id'])
                                     ->where('disease_id', $data['disease_id'])
                                     ->exists();
            if ($exists) {
                return $this->responseError('Đã tồn tại bệnh', 400);
            }

            $categoryDisease = CategoryDisease::create([
                'category_id' => $data['category_id'],
                'disease_id' => $data['disease_id'],
                'disease_name' => $disease['disease_name'],
                'disease_thumbnail' => $disease['disease_thumbnail']
            ]);

            DB::commit();
            $data=$categoryDisease;
            return $this->responseSuccessWithData($data,'Thêm bệnh mới thành công', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }

    public function deleteDiseaseCategory(Request $request) {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $categoryDisease = CategoryDisease::where('category_disease_id', $data['category_disease_id'])->first();

            if (!$categoryDisease) {
                return $this->responseError('Không tìm thấy danh mục bệnh cần xóa', 400);
            }
    
            $categoryDisease->delete();
            
            DB::commit();
            return $this->responseSuccess('Xóa bệnh trong danh mục thành công', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    

    public function getDiseaseCategory(Request $request, $id){
        try {
            $category = Category::find($id);
            if (!$category) {
                return $this->responseError('Không tìm thấy danh mục bệnh', 400);
            }
            $diseases = CategoryDisease::where('category_id', $id)->get();

            if (!$diseases) {
                return $this->responseError('Không có bệnh nào liên quan đến danh mục này', 404);
            }
            $data=$diseases;
            return $this->responseSuccessWithData($data, 'Danh sách bệnh liên quan đến danh mục', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }

    public function getDiseaseUser(Request $request){
        // try {
        //     $categoryType = Category::where('category_type', $request->category_type)
        //                             ->where('category_parent_id', null)->get();
        //     if (!$categoryType) {
        //         return $this->responseError('Không tìm thấy danh mục bệnh', 400);
        //     }


        //     return $this->responseSuccessWithData($categoryType, 'Danh sách danh mục bệnh tương ứng', 200);
        // } catch (Throwable $e) {
        //     DB::rollBack();
        //     return $this->responseError($e->getMessage());
        // }


        try {
            // Bệnh phổ biến và Bệnh theo mùa
            $categoryTypes = [
                'disease_common', 
                'disease_seasonal'
            ];
            $result = [];
    
            foreach ($categoryTypes as $type) {
                $diseases = Category::join('category_diseases', 'categories.category_id', '=', 'category_diseases.category_id')
                    ->where('categories.category_type', $type)
                    ->select(
                        'category_diseases.disease_id',
                        'category_diseases.disease_name',
                        'category_diseases.disease_thumbnail'
                    )
                    ->get();
                $result[$type] = $diseases;
                // $data = Category::where('category_type', $type)
                // ->select(
                //     'category_id',
                //     'category_name',
                //     'category_thumbnail'
                // )
                // ->first();
                // $result[$type] = [
                //     'category_id' => $data['category_id'],
                //     'category_name' => $data['category_name'],
                //     'category_thumbnail' => $data['category_thumbnail'],
                //     'diseases' => $diseases
                // ];
            }


            // Bệnh theo đối tượng
            $categoryTypes = [
                'disease_targetgroup_elderly',
                'disease_targetgroup_male',
                'disease_targetgroup_female',
                'disease_targetgroup_children',
                'disease_targetgroup_teenager',
                'disease_targetgroup_pregnant_women',
            ];
            $result_child = [];
            foreach ($categoryTypes as $type) {
                $diseases = Category::join('category_diseases', 'categories.category_id', '=', 'category_diseases.category_id')
                    ->where('categories.category_type', $type)
                    ->select(
                        'category_diseases.disease_id',
                        'category_diseases.disease_name',
                        'category_diseases.disease_thumbnail'
                    )
                    ->limit(10)
                    ->get();
                $data = Category::where('category_type', $type)
                ->select(
                    'category_id',
                    'category_name',
                    'category_thumbnail'
                )
                ->first();

                $result_child[$type] = [
                    'category_id' => $data['category_id'],
                    'category_name' => $data['category_name'],
                    'category_thumbnail' => $data['category_thumbnail'],
                    'diseases' => $diseases
                ];
            }
            $result['disease_by_target_group'] = $result_child;



            // Bệnh theo bộ phận cơ thể và Bệnh chuyên khoa
            $categoryTypes = [
                'disease_body_part', 
                'disease_specialty'
            ];
            foreach ($categoryTypes as $type) {
                $diseases = Category::where('category_type', $type)
                ->select(
                    'category_id',
                    'category_name',
                    'category_thumbnail'
                ) 
                ->get();
                $result[$type] = $diseases;
            }
            $data=$result;
            return $this->responseSuccessWithData($data, 'Danh sách bệnh được nhóm theo loại danh mục', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function searchDisease(Request $request){
        try {
            $keyword = $request->input('keyword', '');
            $per_page = $request->input('per_page', 20);

            $diseases = Disease::where('disease_name', 'LIKE', "%$keyword%")
                            ->orWhere('general_overview', 'LIKE', "%$keyword%")
                            ->orWhere('symptoms', 'LIKE', "%$keyword%")
                            ->orWhere('cause', 'LIKE', "%$keyword%")
                            ->orWhere('risk_subjects', 'LIKE', "%$keyword%")
                            ->orWhere('diagnosis', 'LIKE', "%$keyword%")
                            ->orWhere('prevention', 'LIKE', "%$keyword%")
                            ->orWhere('treatment_method', 'LIKE', "%$keyword%")
                            ->select('disease_id', 'disease_name', 'disease_thumbnail','general_overview')
                            ->paginate($per_page);
            if ($diseases->isEmpty()) {
                return $this->responseError('Không tìm thấy bệnh nào khớp với từ khóa', 404);
            }
            $data=$diseases;
            return $this->responseSuccessWithData($data, 'Danh sách bệnh tìm kiếm thành công', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    
    public function getCategoryDisease($id){
        try {
            $disease = Disease::find($id);
            if (!$disease) {
                return $this->responseError('Không tìm thấy bệnh', 400);
            }
            // $categories = CategoryDisease::where('disease_id', $id)->get();
            $categories = CategoryDisease::join('categories', 'category_diseases.category_id', '=', 'categories.category_id')
                                        ->where('category_diseases.disease_id', $id)
                                        ->select('category_diseases.category_id',
                                                'categories.category_name',
                                                'category_diseases.category_disease_id',
                                                'category_diseases.disease_id',)
                                        ->get();
            if (empty($categories)) {
                return $this->responseError('Không có danh mục nào liên quan đến bệnh', 400);
            }
            $data=$categories;
            return $this->responseSuccessWithData($data, 'Danh sách danh mục liên quan đến bệnh', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
    
    public function deleteDisease($id){
        DB::beginTransaction();
        try {
            $disease = Disease::find($id);
            if (!$disease) {
                return $this->responseError('Không tìm thấy bệnh', 400);
            }
            
            $delete = !($disease->disease_is_delete);
            $disease->disease_is_delete = $delete;

            $message='';
            if ($delete == 0)
                $message = 'Khôi phục bệnh thành công';
            else 
                $message = 'Xóa bệnh thành công';
            $disease->save();
            DB::commit();
            return $this->responseSuccess($message, 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->responseError($e->getMessage());
        }
    }
}
