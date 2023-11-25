<?php

namespace App\Http\Requests;

use App\Enums\TypeOfMedium;
use Illuminate\Foundation\Http\FormRequest;

class FilterRegistersRequest extends FormRequest
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
        $origins_id_validation = $this->medium->name == strtoupper(TypeOfMedium::Revista->value) ||
                                $this->medium->name == strtoupper(TypeOfMedium::Prensa->value) ||
                                $this->medium->name == strtoupper(TypeOfMedium::Television->value) ? ['required', 'array'] : ['sometimes','array'];
        $states_id_validation  = $this->medium->name == strtoupper(TypeOfMedium::OOH->value) ? ['required', 'array'] : ['sometimes', 'array'];
        return [
            'brands_id'  => ['required', 'array'],
            'origins_id' => $origins_id_validation,
            'states_id'  => $states_id_validation,
            'date_start' => ['sometimes','required'],
            'date_end'   => ['sometimes', 'required']
        ];
    }

    public function messages(): array
    {
        return [
            'brands_id.required' => 'El campo brands_id es requerido',
            'brands_id.array'    => 'El campo brands_id debe ser un array',
            'origins_id.array'   => 'El campo origins_id debe ser un array',
            'states_id.array'   => 'El campo states_id debe ser un array',
            'date.end.required'  => 'El campo fecha fin es requerido'
        ];
    }
}
