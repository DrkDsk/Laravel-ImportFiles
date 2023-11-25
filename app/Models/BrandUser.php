<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandUser extends Model
{
    protected $table = 'brand_users';

    protected $fillable = ["brand_id", "user_id"];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
