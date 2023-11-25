<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand_id'  => 'required',
            'medium_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required'  => 'Marca requerida',
            'medium_id.required' => 'Medio requerido'
        ];
    }
}
