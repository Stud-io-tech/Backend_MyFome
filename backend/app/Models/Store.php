<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'lojas';    

    protected $fillable = [
        'nome',
        'imagem',
        'descricao',
        'public_id',
        'dono_id',
        'ativo',
    ];

    public function owner() {
        return $this->belongsTo(User::class);
    }

    // public function products() {
    //     return $this->hasMany(Product::class);
    // }

}
