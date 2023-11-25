<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = 'id';
    protected $table = 'companies';
    protected $fillable = ['name', 'first_name', 'last_name'];
}
