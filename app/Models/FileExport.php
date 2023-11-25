<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileExport extends Model
{
    use HasFactory;
    protected $fillable = ["medium_id", 'data', "filePath"];
    protected $casts = ['data' => 'array'];
    protected $appends = ['startDate'];

    public function medium(): BelongsTo
    {
        return $this->belongsTo(Medium::class);
    }

    public function getStartDateAttribute()
    {
        return $this->attributes['created_at'];
    }
}
