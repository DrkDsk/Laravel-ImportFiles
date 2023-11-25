<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetContractedStatesRequest extends FormRequest
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
            'brands_id' => ['required', 'array']
        ];
    }

    public function messages(): array
    {
        return [
            'brands_id.required' => 'El campo brands_id es requerido',
            'brands_id.array'    => 'El campo brands_id debe ser un array'
        ];
    }
}
