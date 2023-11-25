<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function companiesBrands() : HasMany
    {
        return $this->hasMany(CompanyBrand::class)->with('brand', 'medium', 'companyBrandLocations.origin', 'companyBrandLocations.state');
    }

    public function companyBrandLocations(): HasManyThrough
    {
        return $this->hasManyThrough(CompanyBrandLocation::class, CompanyBrand::class)->with('origin.medium', 'state');
    }
}
