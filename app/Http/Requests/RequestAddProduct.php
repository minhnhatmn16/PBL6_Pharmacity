<?php

namespace App\Http\Requests;

use App\Rules\ProductImage;
use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class RequestAddProduct extends FormRequest
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
        return [
            'brand_id'=>'required|integer|exists:brands,brand_id',
            'category_id'=>'required|integer|exists:categories,category_id',
            'product_name'=>'required|string|max:100',
            'product_slug' => 'required|string|unique:products,product_slug',
            'product_price' => ['required', 'numeric', 'bail', 'regex:/^\d+(\.\d{1,2})?$/'],
            'product_images' => ['nullable', 'array',new ProductImage()],
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'product_package'=>'string',
            'product_ingredients'=>'string',
            'product_notes'=>'string',
            'product_uses'=>'string',
            'dosage_form'=>'string',
            'place_of_manufacture'=>'string',
            'manufacturer'=>'string',
            'product_description'=>'string',

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
