<?php
namespace App\Repositories;
use App\Models\User;
class UserRepository extends BaseRepository implements UserInterface{
    public function getModel(){
        return User::class;
    }
     public static function getAllUser($filter)
    {
        $filter = (object) $filter;
        $data = (new self)->model
            ->when(!empty($filter->search), function ($q) use ($filter) {
                $q->where(function ($query) use ($filter) {
                    $query->where('user_fullname', 'LIKE', '%' . $filter->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $filter->search . '%');
                });
            })
             ->when(isset($filter->user_is_delete), function ($query) use ($filter) {
                    if($filter->user_is_delete !== 'all'){
                        $query->where('users.user_is_delete', $filter->user_is_delete);
                    }
            })
            ->when(isset($filter->user_is_block), function ($query) use ($filter) {
                if($filter->user_is_block !== 'all'){
                    $query->where('users.user_is_block', $filter->user_is_block);
                }
            })
            ->when(!empty($filter->orderBy), function ($query) use ($filter) {
                $query->orderBy($filter->orderBy, $filter->orderDirection);
            });
        return $data;
    }
  
}