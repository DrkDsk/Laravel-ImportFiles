<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    const PATH_BRAND_IMAGE = '/images/brands';
    protected $guarded = ['id'];
    protected $fillable = ["name", "title", "image", "description", "brand_id"];
    protected $appends = ['fullImagePath'];

    public function getFullImagePathAttribute()
    {
        return asset("storage/" . $this->image);
    }
}
