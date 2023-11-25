<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'name'       => 'required',
            'first_name' => 'required',
            'last_name'  => 'required'
        ];
    }

    public function messages() : array
    {
        return [
            'name.required'          => 'Nombre de la compañía requerido',
            'first_name.required'    => 'Nombre del propietario requerido',
            'last_name.required'     => 'Apellidos del propietario requeridos'
        ];
    }
}
