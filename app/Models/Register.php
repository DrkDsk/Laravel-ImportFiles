<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Register extends Model
{
    use HasFactory;
    protected $guarded = 'id';
    protected $fillable = [
        'readed_file_id',
        'insertion_id',
        'supplier_id',
        'category_id',
        'brand_id',
        'state_id',
        'product_id',
        'origin_id',
        'orientacion',
        'pagina',
        'vista_posicion',
        'direccion',
        'publicacion_date',
        'latitud',
        'longitud',
        'state_name',
        'mes',
        'version',
        'testigo'
    ];

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origin::class)->with('medium');
    }

    public function readedFile(): BelongsTo
    {
        return $this->belongsTo(ReadedFile::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class)->with('country');
    }

    public function insertion(): BelongsTo
    {
        return $this->belongsTo(Insertion::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
