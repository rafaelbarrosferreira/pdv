<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_venda',
        'total',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'itens_vendas', 'venda_id', 'produto_id')->withPivot('quantidade');
    }
}
