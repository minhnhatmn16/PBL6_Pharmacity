<?php

namespace App\Http\Requests;

use App\Traits\APIResponse;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class RequestUpdateSupplier extends FormRequest
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
        $supplier_id = $this->route('id');
        return [
            "supplier_name" => ['required','string',Rule::unique('suppliers')->ignore($supplier_id,'supplier_id')],
            'supplier_email' => ['required', 'string','email', Rule::unique('suppliers')->ignore($supplier_id, 'supplier_id')],
            'supplier_phone' => 'digits:10|numeric',
            'contact_person' => 'string',
            'supplier_address' => 'string'
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
