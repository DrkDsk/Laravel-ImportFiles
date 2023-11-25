<?php

namespace App\Http\Requests;

use App\Services\PermissionService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePackageBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can(PermissionService::PERMISSION_CREATE_BRANDS);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand_id'          => ['required'],
            'state_ids'         => ['nullable'],
            'magazine_ids'      => ['nullable'],
            'newsPapers_ids'    => ['nullable'],
            'stations_ids'      => ['nullable'],
            'tvChannels_ids'    => ['nullable'],
            'isSelectedOOH'     => ['nullable', 'boolean'],
            'isSelectedPrensa'  => ['nullable', 'boolean'],
            'isSelectedRadio'   => ['nullable', 'boolean'],
            'isSelectedRevista' => ['nullable', 'boolean'],
            'isSelectedTV'      => ['nullable', 'boolean']
        ];
    }
}
