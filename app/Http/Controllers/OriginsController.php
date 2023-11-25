<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOriginRequest;
use App\Http\Resources\GeneralResource;
use App\Models\Origin;
use App\Services\FileSystemService;

class OriginsController extends Controller
{
    public function __construct(protected readonly FileSystemService $fileSystemService)
    {
    }

    public function show(Origin $origin): GeneralResource
    {
        $origin['medium'] = $origin->medium;
        $origin['group']  = $origin->group;

        return (new GeneralResource($origin));
    }

    public function update(Origin $origin, UpdateOriginRequest $request): GeneralResource
    {
        if ($request->hasFile('image')) {
            $image = $this->fileSystemService->store(Origin::PATH_ORIGIN_IMAGE);
            if ($origin->image) {
                $this->fileSystemService->delete($origin->image);
            }

            $origin->update(["image" => $image]);
        }

        $origin->update([
            'name' => $request->get('name'),
            'group_id' => $request->get('group_id')
        ]);

        return (new GeneralResource($origin));
    }
}
