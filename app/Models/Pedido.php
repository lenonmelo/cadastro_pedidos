<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produto',
        'valor',
        'data',
        'cliente_id',
        'pedido_status_id',
        'ativo'
    ];

    public function cliente()
    {
        return $this->belongsTo(cliente::class);
    }

    public function pedidoStatus()
    {
        return $this->belongsTo(PedidoStatus::class);
    }

    public function imagens()
    {
        return $this->hasMany(PedidosImagem::class, 'pedido_id');
    }
}
