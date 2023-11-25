<?php

namespace App\Services;

use App\Models\BrandUser;
use App\Models\User;

class BrandService {

    public function create(User $user, $selectedBrands)
    {
        $user->brands()->delete();
        foreach ($selectedBrands as $brand_id) {
            BrandUser::create([
                "brand_id" => $brand_id,
                "user_id"  => $user->id
            ]);
        }
    }
}
