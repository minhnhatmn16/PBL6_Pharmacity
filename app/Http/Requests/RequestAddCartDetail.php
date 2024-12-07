<?php

namespace App\Http\Requests;

use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RequestAddCartDetail extends FormRequest
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
             // 'cart_id' => 'required|exists:carts,cart_id',
            'product_id' => 'required|integer',
            // 'cart_quantity' => 'required|integer|min:1',
            'cart_quantity' => 'required|integer',

            // 'cart_price' => ['required', 'numeric', 'bail', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        return $this->responseErrorValidate($errors, $validator);
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            // 'cart_id.required' => 'Cart ID is required',
            // 'cart_id.exists' => 'Cart ID must exist in the carts table',
            'product_id.required' => 'Product ID is required',
            'product_id.exists' => 'Product ID must exist in the products table',
            'cart_quantity.required' => 'Quantity of the product is required',
            'cart_quantity.integer' => 'Quantity must be an integer',
            'cart_quantity.min' => 'Quantity must be at least 1',
            // 'cart_price.required' => 'Price is required',
            // 'cart_price.numeric' => 'Price must be a valid number',
            // 'cart_price.regex' => 'Price must be a valid decimal number with up to 2 decimal places',
        ];
    }
}
