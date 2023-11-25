<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyBrandLocation extends Model
{
    use HasFactory;
    protected $table = 'company_brands_locations';
    protected $guarded = 'id';
    protected $fillable = ['company_brand_id', 'state_id', 'origin_id'];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origin::class);
    }

    public function companyBrand(): BelongsTo
    {
        return $this->belongsTo(CompanyBrand::class);
    }
}
