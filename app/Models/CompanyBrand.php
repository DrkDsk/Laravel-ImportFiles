<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyBrand extends Model
{
    use HasFactory;
    protected $table = 'companies_brands';
    protected $guarded = 'id';
    protected $fillable = ['package_id', 'brand_id', 'medium_id', 'status'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function companyBrandLocations(): HasMany
    {
        return $this->hasMany(CompanyBrandLocation::class);
    }

    public function medium() : BelongsTo
    {
        return $this->belongsTo(Medium::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
