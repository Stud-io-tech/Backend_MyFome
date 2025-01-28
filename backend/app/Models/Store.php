<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'stores';    

    protected $fillable = [
        'name',
        'image',
        'description',
        'public_id',
        'owner_id',
        'active',
        'whatsapp',
    ];

    public function owner() {
        return $this->belongsTo(User::class);
    }

    // public function products() {
    //     return $this->hasMany(Product::class);
    // }

}
