<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','description'];

    
    public function venda(){
        return $this->belongsToMany(Venda::class, 'itens_vendas', 'venda_id', 'produto_id')->withPivot('quantidade');
    }
}
