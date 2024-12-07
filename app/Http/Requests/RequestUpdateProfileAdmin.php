<?php

namespace App\Http\Requests;

use App\Traits\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RequestUpdateProfileAdmin extends FormRequest
{
    use APIResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id_admin=Auth::guard('admin_api')->user()->admin_id;
        return [
            // 'email' => ['required','string','email','max:100',Rule::unique('admins')->ignore($id_admin,'admin_id')],
            'admin_fullname' =>'required|string|between:2,60',
            // 'admin_phone' => 'digits:10|numeric',
            // 'admin_birthday' =>'date',
            // 'admin_gender'=>'in:1,0',
            'admin_avatar'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        return $this->responseErrorValidate($errors, $validator);
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'body.required' => 'Body is required',
        ];
    }
}
