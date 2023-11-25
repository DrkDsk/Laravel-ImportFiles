<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Origin extends Model
{
    use HasFactory;
    const PATH_ORIGIN_IMAGE = '/images/origins';
    protected $guarded = 'id';
    protected $fillable = ['medium_id', 'group_id', 'name', 'image'];
    protected $appends = ['fullImagePath'];

    public function medium(): BelongsTo
    {
        return $this->belongsTo(Medium::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function getFullImagePathAttribute(): string
    {
        return asset("storage/" . $this->image);
    }
}
