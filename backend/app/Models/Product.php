<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'store_id',
        'description',
        'price',
        'amount',
        'sold',
        'active',
        'image',
        'public_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
