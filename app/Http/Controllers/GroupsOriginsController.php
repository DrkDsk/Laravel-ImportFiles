<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeneralResource;
use App\Models\Group;
use App\Repositorys\OriginsRepository;

class GroupsOriginsController extends Controller
{

    public function __construct(private readonly OriginsRepository $originsRepository)
    {
    }

    public function index(Group $group): GeneralResource
    {
        return (new GeneralResource($this->originsRepository->getOriginsByGroupId($group->id)));
    }
}
