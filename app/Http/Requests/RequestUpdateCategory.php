<?php

namespace App\Http\Requests;

use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
class RequestUpdateCategory extends FormRequest
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
        $id = $this->route('id');
        return [
            'category_name' => ['required', 'string', Rule::unique('categories')->ignore($id, 'category_id')],
            'category_slug' => ['required', 'string', Rule::unique('categories')->ignore($id, 'category_id')],
            'category_thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_parent_id' => 'nullable|exists:categories,category_id',
            'category_type' => 'string',
            'category_description' => 'string',
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
