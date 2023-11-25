<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageCompany extends Model
{
    use HasFactory;
    protected $fillable = ['package_id', 'company_id'];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
