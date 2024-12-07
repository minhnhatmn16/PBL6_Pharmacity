<?php

namespace App\Http\Requests;

use App\Traits\APIResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RequestAddImport extends FormRequest
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
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'import_date' => 'required|date',
            'import_details' => 'required|array',
            'import_details.*.product_id' => 'required|exists:products,product_id',
            'import_details.*.import_quantity' => 'required|numeric|min:1',
            'import_details.*import_price' => ['required', 'numeric', 'bail', 'regex:/^\d+(\.\d{1,2})?$/'],
            'import_details.*product_expiry_date' => 'required|date',
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
