<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompanyRequest;
use App\Http\Resources\GeneralResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function store(CreateCompanyRequest $request) : GeneralResource
    {
        $company = Company::firstOrCreate(
            ['name' => $request->validated('name')],
            [
                'name'       => $request->validated('name'),
                'first_name' => $request->validated('first_name'),
                'last_name'  => $request->validated('last_name')
            ],
        );

        return (new GeneralResource($company));
    }
}
