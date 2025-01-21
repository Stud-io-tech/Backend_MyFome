<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'loja_id',
        'descricao',
        'preco',
        'quantidade',
        'vendido',
        'ativo',
        'imagem',
        'public_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
