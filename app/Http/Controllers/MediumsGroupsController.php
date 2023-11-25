<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroupRequest;
use App\Http\Resources\GeneralResource;
use App\Models\Group;
use App\Models\Medium;

class MediumsGroupsController extends Controller
{
    public function store(Medium $medium, CreateGroupRequest $request): GeneralResource
    {
        $group = Group::firstOrCreate(
            [
                'medium_id' => $medium->id,
                'name'      => $request->get('name'),
                'description' => $request->get('description')
            ],
            [
                'medium_id' => $medium->id,
                'name'      => $request->get('name'),
                'description' => $request->get('description')
            ]
        );

        return (new GeneralResource($group));
    }
}
