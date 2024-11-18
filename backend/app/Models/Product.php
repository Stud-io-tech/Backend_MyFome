<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'store_id',
        'image',
        'public_id',
    ];

    public function store() {
        return $this->belongsTo(Store::class);
    }
}
