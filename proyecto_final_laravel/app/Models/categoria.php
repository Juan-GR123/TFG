<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Nombre de la tabla si no sigue la convención Laravel (opcional si es "categorias")
    protected $table = 'categorias';

    // Campos que pueden ser asignados en masa
    protected $fillable = ['nombre'];

    // Si no usas timestamps en tu tabla (created_at y updated_at)
    public $timestamps = false;

    // Si necesitas obtener categorías ordenadas
    public static function obtenerTodas()
    {
        return self::orderBy('id', 'desc')->get();
    }

    public static function obtenerPorId($id)
    {
        return self::find($id);
    }

    // Si necesitas una eliminación condicional como en el código antiguo
    public static function eliminarPorNombreYId($id, $nombre)
    {
        return self::where('id', $id)->where('nombre', $nombre)->delete();
    }

    //Es util para saber en que productos esta cada categoria
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    //Es útil, por ejemplo, para ver en qué pedidos ha sido incluido un producto con la categoria específica.
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'lineas_pedidos', 'producto_id', 'pedido_id');
    }
}
