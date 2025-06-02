<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'provincia',
        'localidad',
        'direccion',
        'coste',
        'estado',
        'fecha',
        'hora'
    ];

    public $timestamps = false;

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'lineas_pedidos', 'pedido_id', 'producto_id');
    }

    // Obtener todos los pedidos
    public static function obtenerTodos()
    {
        return self::orderBy('id', 'desc')->get();
    }

    // Obtener pedido por ID
    public static function obtenerPorId($id)
    {
        return self::find($id);
    }

    // Obtener último pedido por usuario
    public static function ultimoPedidoPorUsuario($usuarioId)
    {
        return self::where('usuario_id', $usuarioId)
            ->orderBy('id', 'desc')
            ->select('id', 'coste')
            ->first();
    }

    // Obtener todos los pedidos de un usuario
    public static function todosPorUsuario($usuarioId)
    {
        return self::where('usuario_id', $usuarioId)
            ->orderBy('id', 'desc')
            ->get();
    }

    // Guardar líneas de pedido desde la sesión
    public function guardarLineasDesdeSesion()
    {
        $guardado = false;
        $carrito = Session::get('carrito', []);

        foreach ($carrito as $elemento) {
            $this->productos()->attach($elemento['producto']->id);
            $guardado = true;
        }

        return $guardado;
    }

    // Editar estado
    public function actualizarEstado($nuevoEstado)
    {
        $this->estado = $nuevoEstado;
        return $this->save();
    }

    // Eliminar pedido y líneas
    public function eliminarConLineas()
    {
        $this->productos()->detach();
        return $this->delete();
    }

    public function saveLinea($pedido_id)
    {
        $carrito = Session::get('carrito', []);

        if (empty($carrito)) {
            return false;
        }

        foreach ($carrito as $producto) {
            dd($producto);
            $linea = new LineaPedido();
            $linea->pedido_id = $pedido_id;
            $linea->producto_id = $producto->id;
            $linea->save();
        }

        return true;
    }

    public function tieneAcceso()
    {
        if (!$this->fecha ||  !$this->hora || !$this->tiempo_alquiler) return false;

        // Convertir la fecha de inicio del alquiler
        $fechaInicio = \Carbon\Carbon::parse($this->fecha . ' ' . $this->hora);
         // Verificar la fecha de inicio
        //  Log::info('Fecha inicio: ' . $fechaInicio);
       

        // Calcular la fecha de finalización sumando el tiempo de alquiler en minutos
        $fechaFin = $fechaInicio->copy()->addMonths((int) $this->tiempo_alquiler);
         // Verificar la fecha de finalización
        // Log::info('Fecha fin: ' . $fechaFin);

        // Verificar si la fecha actual es antes o igual a la fecha de finalización
        // Log::info('Fecha actual: ' . now());

        

        // Verificar si la fecha actual es antes o igual a la fecha de finalización
        return now()->lessThanOrEqualTo($fechaFin);
    } 
}
