<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class LineaPedido extends Model
{
    protected $table = 'lineas_pedidos';
    public $timestamps = false;

    protected $fillable = [
        'pedido_id',
        'producto_id',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
