<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosImagem extends Model
{
    use HasFactory;

    protected $table = 'pedidos_imagens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pedido_id',
        'imagem',
        'capa'
    ];
}
