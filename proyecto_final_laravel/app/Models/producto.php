<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'fecha',
        'imagen',
        'trailer',
        'pelicula',
        'reparto'
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Métodos personalizados

    public static function getProductos()
    {
        return self::orderByDesc('id')->get();
    }

    public static function getProductosPorCategoria($categoria_id)
    {
        return self::where('categoria_id', $categoria_id)
            ->orderByDesc('id')
            ->get();
    }

    public static function getProductoPorId($id)
    {
        return self::find($id);
    }

    public static function getRandom($limit)
    {
        return self::inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function eliminarProducto()
    {
        // Si hay relaciones con líneas de pedidos, debes definirlas y eliminarlas así:
        // $this->lineasPedidos()->delete();
        // Por ahora, solo se eliminará el producto directamente
        return $this->delete();
    }

    //Es útil, por ejemplo, para ver en qué pedidos ha sido incluido un producto específico.
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'lineas_pedidos', 'producto_id', 'pedido_id');
    }

    

    // Si necesitas editar un producto manualmente, puedes usar:
    // $producto->update([...]);
}
