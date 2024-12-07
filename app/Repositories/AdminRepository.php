<?php
namespace App\Repositories;
use App\Models\Admin;
class AdminRepository extends BaseRepository implements AdminInterface{
    public function getModel(){
        return Admin::class;
    }
   
    public static function getAllAdmin($filter, $role_admin)
    {
       $filter =(object) $filter;
       $data=(new self)->model->when(!empty($filter->search),function($q) use ($filter){
           $q->where(function($query) use ($filter){
               $query->where('admin_fullname','LIKE','%'.$filter->search.'%')
               ->orWhere('email','LIKE','%'.$filter->search.'%');
           });
            })
             ->when(isset($filter->admin_is_delete),function($query) use ($filter){
                if($filter->admin_is_delete !== 'all'){
                    $query->where('admins.admin_is_delete',$filter->admin_is_delete);
                }
            })
            ->when(!empty($filter->orderBy),function($query) use ($filter){
           $query->orderBy($filter->orderBy,$filter->orderDirection);
            })
            ->where('admin_is_admin', '<', $role_admin);
        return $data;
    }
  
}