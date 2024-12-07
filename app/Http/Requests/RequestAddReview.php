<?php

namespace App\Http\Requests;

use App\Rules\ProductImage;
use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class RequestAddReview extends FormRequest
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
            'order_id' => 'required|integer|exists:orders,order_id',
            'product_id' => 'required|integer|exists:products,product_id',
            'review_rating' => 'integer|min:1|max:5',
            'review_images' => ['nullable', 'array', new ProductImage()],
            'review_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'review_comment' => 'nullable|string',
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
