<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\APIResponse;
use Illuminate\Contracts\Validation\Validator;

class RequestDiseaseAdd extends FormRequest
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

    public function rules()
    {
        return [
            'disease_name' => 'required|string|max:255',
            // 'disease_thumbnail' => 'nullable|image|max:2048',
            'disease_thumbnail' => 'nullable|file|image',
            'general_overview' => 'required|string',
            'symptoms' => 'required|string',
            'cause' => 'required|string',
            'risk_subjects' => 'required|string',
            'diagnosis' => 'required|string',
            'prevention' => 'required|string',
            'treatment_method' => 'required|string',
            'disease_is_delete' => 'boolean',
            'disease_is_show' => 'boolean',
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
