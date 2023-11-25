<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReadedFile extends Model
{
    use HasFactory;
    protected $fillable = ["fileName", "origin", "start", "finish", "exception", "count"];

    public function registers(): HasMany
    {
        return $this->hasMany(Register::class);
    }
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function getCountRegistersAttribute() {
        return $this->registers()->count();
    }
}
